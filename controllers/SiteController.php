<?php
namespace core\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use core\models\Business;

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
        $flag = false;
        
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
            WHERE constraint_type = \'FOREIGN KEY\';
        ')->queryAll();
        
        $alterPrimaryKey = $db->createCommand('
            SELECT DISTINCT \'ALTER TABLE "public"."\' || tc.table_name || \'" ALTER COLUMN "\' || c.column_name || \'" DROP DEFAULT,ALTER COLUMN "\' || c.column_name || \'" TYPE character varying(32);\'
            FROM information_schema.table_constraints tc 
            JOIN information_schema.constraint_column_usage AS ccu USING (constraint_schema, constraint_name) 
            JOIN information_schema.columns AS c ON c.table_schema = tc.constraint_schema AND tc.table_name = c.table_name AND ccu.column_name = c.column_name
            WHERE constraint_type = \'PRIMARY KEY\';
        ')->queryColumn();
        
        //BEGIN:change value primary key and foreign key
        
        $selectPrimaryKey = $db->createCommand('
            SELECT tc.table_name, ccu.column_name
            FROM information_schema.table_constraints tc 
            JOIN information_schema.constraint_column_usage AS ccu USING (constraint_schema, constraint_name) 
            JOIN information_schema.columns AS c ON c.table_schema = tc.constraint_schema AND tc.table_name = c.table_name AND ccu.column_name = c.column_name
            WHERE constraint_type = \'PRIMARY KEY\' AND ccu.column_name NOT IN(\'business_id\', \'registry_business_id\', \'user_id\');
        ')->queryAll();
            
        $selectTable = [];
        
        foreach ($selectPrimaryKey as $dataPrimaryKey) {
            
            $selectTable[$dataPrimaryKey['table_name']] = $db->createCommand('
                SELECT "' . $dataPrimaryKey['column_name'] . '" FROM "' . $dataPrimaryKey['table_name'] . '";
            ')->queryAll();
        }
        
        $updateIdPrimaryTable = [];
        $updateIdForeignTable = [];
        
        foreach ($selectTable as $tableName => $tables) {
            
            foreach ($tables as $table) {
                
                $updateIdPrimaryTable[$tableName][] = 'UPDATE "' . $tableName . '" SET "id"=\'123456\' WHERE "id"=\'' . $table['id'] . '\';';
                
                foreach ($alterForeignKey as $data) {
                    
                    if ($data['reference_table'] == $tableName) {
                        
                        $updateIdForeignTable[$tableName][] = 'UPDATE "' . $data['table'] . '" SET "' . $data['column_name'] . '"=\'123456\' WHERE id=\'' . $table['id'] . '\';';
                    }
                }
            }
        }
        
        //END
        
        $addForeignKey = $db->createCommand('
            SELECT DISTINCT \'ALTER TABLE "public"."\' || tc.table_name || \'" ADD constraint "\' || tc.constraint_name || \'" foreign key ("\' || kcu.column_name || \'") references "public"."\' || ccu.table_name || \'" (\' || ccu.column_name || \');\'
            FROM information_schema.table_constraints AS tc 
                JOIN information_schema.key_column_usage AS kcu
                  ON tc.constraint_name = kcu.constraint_name
                JOIN information_schema.constraint_column_usage AS ccu
                  ON ccu.constraint_name = tc.constraint_name
            WHERE constraint_type = \'FOREIGN KEY\';
        ')->queryColumn();
        
        //$db->createCommand()->update('business', ['id' => '11asd'], 'id=\'11aa\'')->execute();
        
        $transaction->commit();
        
        echo'<pre>';print_r($updateIdForeignTable);exit;
    }
}
