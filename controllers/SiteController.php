<?php

namespace core\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'migrate-id', 'error'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionMigrateId()
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        
        $addForeignKey = $db->createCommand('
            SELECT DISTINCT \'ALTER TABLE "public"."\' || tc.table_name || \'" ADD constraint "\' || tc.constraint_name || \'" foreign key ("\' || kcu.column_name || \'") references "public"."\' || ccu.table_name || \'" (\' || ccu.column_name || \');\'
            FROM information_schema.table_constraints AS tc
                JOIN information_schema.key_column_usage AS kcu
                  ON tc.constraint_name = kcu.constraint_name
                JOIN information_schema.constraint_column_usage AS ccu
                  ON ccu.constraint_name = tc.constraint_name
            WHERE constraint_type = \'FOREIGN KEY\' AND kcu.column_name NOT IN(\'status_approval_id\', \'require_status_approval_id\');
        ')->queryColumn();
        
        $alterForeignKey = $db->createCommand('
            SELECT \'ALTER TABLE "public"."\' || tc.table_name || \'" drop constraint "\' || tc.constraint_name || \'";
            ALTER TABLE "public"."\' || tc.table_name || \'" ALTER COLUMN "\' || kcu.column_name || \'" TYPE character varying(32);\' as query,
            kcu.table_name as table, kcu.column_name, ccu.table_name as reference_table
            
            FROM 
                information_schema.table_constraints AS tc 
                JOIN information_schema.key_column_usage AS kcu
                  ON tc.constraint_name = kcu.constraint_name
                JOIN information_schema.constraint_column_usage AS ccu
                  ON ccu.constraint_name = tc.constraint_name
            WHERE constraint_type = \'FOREIGN KEY\' AND kcu.column_name NOT IN(\'status_approval_id\', \'require_status_approval_id\');
        ')->queryAll();
        
        foreach ($alterForeignKey as $alterFK) {
            
            $alterFKTemp = explode(';', $alterFK['query']);
            
            $db->createCommand($alterFKTemp[0])->execute();
            $db->createCommand($alterFKTemp[1])->execute();
        }
        
        $alterPrimaryKey = $db->createCommand('
            SELECT DISTINCT \'ALTER TABLE "public"."\' || tc.table_name || \'" ALTER COLUMN "\' || c.column_name || \'" DROP DEFAULT,ALTER COLUMN "\' || c.column_name || \'" TYPE character varying(32);\'
            FROM information_schema.table_constraints tc 
            JOIN information_schema.constraint_column_usage AS ccu USING (constraint_schema, constraint_name) 
            JOIN information_schema.columns AS c ON c.table_schema = tc.constraint_schema AND tc.table_name = c.table_name AND ccu.column_name = c.column_name
            WHERE constraint_type = \'PRIMARY KEY\' AND tc.table_name NOT IN(\'status_approval\');
        ')->queryColumn();
        
        foreach ($alterPrimaryKey as $alterPK) {
            
            $db->createCommand($alterPK)->execute();
        }
        
        //BEGIN:change value primary key and foreign key
        
        $selectPrimaryKey = $db->createCommand('
            SELECT tc.table_name, ccu.column_name
            FROM information_schema.table_constraints tc 
            JOIN information_schema.constraint_column_usage AS ccu USING (constraint_schema, constraint_name) 
            JOIN information_schema.columns AS c ON c.table_schema = tc.constraint_schema AND tc.table_name = c.table_name AND ccu.column_name = c.column_name
            WHERE constraint_type = \'PRIMARY KEY\' AND ccu.column_name NOT IN(\'business_id\', \'registry_business_id\', \'transaction_session_id\', \'user_id\') AND tc.table_name NOT IN(\'status_approval\');
        ')->queryAll();
            
        $selectTable = [];
        
        foreach ($selectPrimaryKey as $dataPrimaryKey) {
            
            $selectTable[$dataPrimaryKey['table_name']] = $db->createCommand('
                SELECT "' . $dataPrimaryKey['column_name'] . '" FROM "' . $dataPrimaryKey['table_name'] . '";
            ')->queryAll();
        }
        
        foreach ($selectTable as $tableName => $tables) {
            
            $function = 'get_' . $tableName . '_id()';
            
            $db->createCommand('ALTER TABLE "public"."' . $tableName . '" ALTER COLUMN "id" SET DEFAULT ' . $function . ';')->execute();
            
            foreach ($tables as $table) {
                
                $newID = $db->createCommand('UPDATE "' . $tableName . '" SET "id"=' . $function . ' WHERE "id"=\'' . $table['id'] . '\' RETURNING "id";')->queryColumn();
                
                foreach ($alterForeignKey as $data) {
                    
                    if ($data['reference_table'] == $tableName) {
                        
                        $db->createCommand('UPDATE "' . $data['table'] . '" SET "' . $data['column_name'] . '"=\'' . $newID[0] . '\' WHERE "' . $data['column_name'] . '"=\'' . $table['id'] . '\';')->execute();
                    }
                }
            }
        }
        
        //END
        
        foreach ($addForeignKey as $addFK) {
            
            $db->createCommand($addFK)->execute();
        }
        
        $transaction->commit();
    }
}
