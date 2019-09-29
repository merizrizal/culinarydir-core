<?php

namespace core\controllers;

use core\models\ApplicationBusiness;
use core\models\LogStatusApproval;
use core\models\Person;
use core\models\RegistryBusiness;
use core\models\RegistryBusinessCategory;
use core\models\RegistryBusinessContactPerson;
use core\models\RegistryBusinessDelivery;
use core\models\RegistryBusinessFacility;
use core\models\RegistryBusinessHour;
use core\models\RegistryBusinessHourAdditional;
use core\models\RegistryBusinessImage;
use core\models\RegistryBusinessPayment;
use core\models\RegistryBusinessProductCategory;
use core\models\StatusApproval;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

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
                        'actions' => ['index', 'restore-pending-registry-business'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['error'],
                        'allow' => true
                    ]
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

    /*
     *
    public function actionMigrateId()
    {
        $db = \Yii::$app->db;
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
    */

    /*
    public function actionMigrateUserAkses() {

        $transaction = \Yii::$app->db->beginTransaction();
        $flag = false;

        $modelUserLevel = UserLevel::find()
            ->andWhere(['nama_level' => 'User'])
            ->asArray()->one();

        $userLevelId = $modelUserLevel['id'];

        $modelUser = User::find()
            ->andWhere(['not_active' => false])
            ->all();


        foreach ($modelUser as $model) {

            $id = $model->id;

            $tempUserAkses = [];

            $isExist = false;

            foreach ($model->userRoles as $userRole) {

                if (($isExist = ($userRole->unique_id == $id . '-' . $userLevelId))) {

                    $modelUserRole = $userRole;
                    break;
                }
            }

            if (!$isExist) {

                $modelUserRole = new UserRole();
                $modelUserRole->user_id = $model->id;
                $modelUserRole->user_level_id = $userLevelId;
                $modelUserRole->unique_id = $id . '-' . $userLevelId;
            }

            $modelUserRole->is_active = true;

            if (!($flag = $modelUserRole->save())) {

                break;
            } else {

                $modelUserAkses = UserAkses::find()
                    ->andWhere(['user_level_id' => $userLevelId])
                    ->asArray()->all();

                foreach ($modelUserAkses as $dataUserAkses) {

                    $isExist = false;

                    foreach ($model->userAksesAppModules as $userAksesAppModule) {

                        if (($isExist = ($userAksesAppModule->unique_id == $id . '-' . $dataUserAkses['user_app_module_id']))) {

                            $modelUserAksesAppModule = $userAksesAppModule;
                            break;
                        }
                    }

                    if (!$isExist) {

                        $modelUserAksesAppModule = new UserAksesAppModule();
                        $modelUserAksesAppModule->unique_id = $id . '-' . $dataUserAkses['user_app_module_id'];
                        $modelUserAksesAppModule->user_id = $id;
                        $modelUserAksesAppModule->user_app_module_id = $dataUserAkses['user_app_module_id'];
                        $modelUserAksesAppModule->is_active = $dataUserAkses['is_active'];
                        $modelUserAksesAppModule->used_by_user_role = [$modelUserRole->unique_id];
                    } else {

                        $jsonData = $modelUserAksesAppModule->used_by_user_role;
                        $jsonDataExist = false;

                        if (!empty($jsonData)) {

                            foreach ($jsonData as $json) {

                                if ($json == $modelUserRole->unique_id) {

                                    $jsonDataExist = true;
                                    break;
                                }
                            }
                        }

                        if (!$jsonDataExist) {

                            if (!empty($jsonData)) {

                                array_push($jsonData, $modelUserRole->unique_id);
                            } else {

                                $jsonData = [$modelUserRole->unique_id];
                            }

                            $modelUserAksesAppModule->used_by_user_role = $jsonData;
                        }

                        if (empty($tempUserAkses[$dataUserAkses['user_app_module_id']])) {

                            $tempUserAkses[$dataUserAkses['user_app_module_id']] = $dataUserAkses['is_active'];
                        } else {

                            $tempUserAkses[$dataUserAkses['user_app_module_id']] = $dataUserAkses['is_active'] ? $dataUserAkses['is_active'] : $tempUserAkses[$dataUserAkses['user_app_module_id']];
                        }

                        $modelUserAksesAppModule->is_active = $tempUserAkses[$dataUserAkses['user_app_module_id']];
                    }

                    if (!($flag = $modelUserAksesAppModule->save())) {

                        break 2;
                    }
                }
            }

            if ($flag) {

                foreach ($model->userRoles as $existModelUserRole) {

                    $isExist = false;

                    if ($existModelUserRole->user_level_id == $userLevelId) {

                        $isExist = true;
                    }

                    if (!$isExist && $existModelUserRole->is_active) {

                        $existModelUserRole->is_active = false;

                        if (!($flag = $existModelUserRole->save())) {

                            break;
                        } else {

                            $modelUserAkses = UserAkses::find()
                                ->andWhere(['user_level_id' => $existModelUserRole->user_level_id])
                                ->asArray()->all();

                            foreach ($modelUserAkses as $dataUserAkses) {

                                foreach ($model->userAksesAppModules as $existModelUserAksesAppModule) {

                                    if ($existModelUserAksesAppModule->unique_id == $id . '-' . $dataUserAkses['user_app_module_id']) {

                                        $jsonData = $existModelUserAksesAppModule->used_by_user_role;
                                        $indexSearch = array_search($existModelUserRole->unique_id, $jsonData);

                                        if ($indexSearch == 0 || !empty($indexSearch)) {

                                            unset($jsonData[$indexSearch]);

                                            $existModelUserAksesAppModule->used_by_user_role = $jsonData;
                                        }

                                        if (!($flag = $existModelUserAksesAppModule->save())) {

                                            break 3;
                                        } else {

                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($flag) {

            echo "Berhasil";

            $transaction->commit();
        } else {

            echo "Gagal";

            $transaction->rollBack();
        }
    }
    */

    public function actionRestorePendingRegistryBusiness() {

        $dbv21 = new \yii\db\Connection([
            'dsn' => 'pgsql:host=localhost;dbname=business_directory_v21',
            'username' => 'root',
            'password' => '@sikmakan123Root',
            'charset' => 'utf8',
            'schemaMap' => [
                'pgsql'=> [
                    'class'=>'yii\db\pgsql\Schema',
                    'defaultSchema' => 'public' //specify your schema here
                ]
            ],
        ]);

        $query1 = RegistryBusiness::find()
            ->select('registry_business.id, membership_type.name, user.full_name, registry_business.*')
            ->joinWith([
                'membershipType',
                'userInCharge',
                'applicationBusiness',
                'applicationBusiness.logStatusApprovals',
                'district',
                'village'
            ])
            ->andWhere(['log_status_approval.status_approval_id' => 'PNDG'])
            ->andWhere(['log_status_approval.is_actual' => true])
            ->andWhere('registry_business.application_business_counter = application_business.counter')
            ->andWhere(['BETWEEN', '(registry_business.created_at + interval \'7 hour\')::date', '2019-09-23', '2019-09-26'])
            ->distinct()
            ->all($dbv21);

        $query2 = RegistryBusiness::find()
            ->select('registry_business.id, membership_type.name, user.full_name, registry_business.*')
            ->joinWith([
                'membershipType',
                'userInCharge',
                'applicationBusiness',
                'applicationBusiness.logStatusApprovals',
                'district',
                'village'
            ])
            ->andWhere(['log_status_approval.status_approval_id' => 'PNDG'])
            ->andWhere(['log_status_approval.is_actual' => true])
            ->andWhere('registry_business.application_business_counter = application_business.counter')
            ->andWhere(['BETWEEN', '(registry_business.created_at + interval \'7 hour\')::date', '2019-09-23', '2019-09-26'])
            ->distinct()
            ->all();

        $content = '';
        $restoreData = [];

        foreach ($query1 as $data1) {

            $noData = true;

            foreach ($query2 as $data2) {

                if ($data1->unique_name == $data2->unique_name) {

                    $noData = false;
                    break;
                }
            }

            if ($noData && $data1->unique_name != 'fried-chicken-pak-supardi-satria-raya'&& $data1->unique_name != 'jajagongan-satria-raya' && $data1->unique_name != 'pink-makaroni-satria-raya') {

                $restoreData[] = $data1;
            }
        }

        $transaction = \Yii::$app->db->beginTransaction();
        $flag = false;

        $model = new RegistryBusiness();

        foreach ($restoreData as $data) {

            $modelApplicationBusiness = new ApplicationBusiness();
            $modelApplicationBusiness->user_in_charge = $data->userInCharge->id;
            $modelApplicationBusiness->counter = 1;

            if (($flag = $modelApplicationBusiness->save())) {

                $modelLogStatusApproval = new LogStatusApproval();
                $modelLogStatusApproval->application_business_id = $modelApplicationBusiness->id;
                $modelLogStatusApproval->status_approval_id = StatusApproval::find()->andWhere(['group' => 0])->asArray()->one()['id'];
                $modelLogStatusApproval->is_actual = true;
                $modelLogStatusApproval->application_business_counter = $modelApplicationBusiness->counter;

                if (($flag = $modelLogStatusApproval->save())) {

                    $model->application_business_id = $modelApplicationBusiness->id;
                    $model->user_in_charge = $modelApplicationBusiness->user_in_charge;
                    $model->application_business_counter = $modelApplicationBusiness->counter;
                    $model->membership_type_id = $data->membership_type_id;
                    $model->name = $data->name;
                    $model->unique_name = $data->unique_name;
                    $model->email = $data->email;
                    $model->phone1 = $data->phone1;
                    $model->phone2 = $data->phone2;
                    $model->phone3 = $data->phone3;
                    $model->address_type = $data->address_type;
                    $model->address = $data->address;
                    $model->address_info = $data->address_info;
                    $model->city_id = $data->city_id;
                    $model->district_id = $data->district_id;
                    $model->village_id = $data->village_id;
                    $model->coordinate = $data->coordinate;
                    $model->price_min = !empty($data->price_min) ? $data->price_min : 0;
                    $model->price_max = !empty($data->price_max) ? $data->price_max : 0;
                    $model->created_at = $data->created_at;
                    $model->note = $data->note;
                    $model->note_business_hour = $data->note_business_hour;
                    $model->about = $data->about;
                    $model->menu = $data->menu;

                    if (($flag = $model->save())) {

                        foreach ($data->registryBusinessCategories as $registryBusinessCategory) {

                            $newModelRegistryBusinessCategory = new RegistryBusinessCategory();
                            $newModelRegistryBusinessCategory->unique_id = $model->id . '-' . $registryBusinessCategory->id;
                            $newModelRegistryBusinessCategory->registry_business_id = $model->id;
                            $newModelRegistryBusinessCategory->category_id = $registryBusinessCategory->id;
                            $newModelRegistryBusinessCategory->is_active = true;

                            if (!($flag = $newModelRegistryBusinessCategory->save())) {

                                break;
                            }
                        }
                    }

                    if ($flag) {

                        foreach ($data->registryBusinessProductCategories as $registryBusinessProductCategory) {

                            $newModelRegistryBusinessProductCategory = new RegistryBusinessProductCategory();
                            $newModelRegistryBusinessProductCategory->unique_id = $model->id . '-' . $registryBusinessProductCategory->id;
                            $newModelRegistryBusinessProductCategory->registry_business_id = $model->id;
                            $newModelRegistryBusinessProductCategory->product_category_id = $registryBusinessProductCategory->id;
                            $newModelRegistryBusinessProductCategory->is_active = true;

                            if (!($flag = $newModelRegistryBusinessProductCategory->save())) {

                                break;
                            }
                        }
                    }

                    if ($flag) {

                        foreach ($data->registryBusinessFacilities as $registryBusinessFacility) {

                            $newModelRegistryBusinessFacility = new RegistryBusinessFacility();
                            $newModelRegistryBusinessFacility->unique_id = $model->id . '-' . $registryBusinessFacility->id;
                            $newModelRegistryBusinessFacility->registry_business_id = $model->id;
                            $newModelRegistryBusinessFacility->facility_id = $registryBusinessFacility->id;
                            $newModelRegistryBusinessFacility->is_active = true;

                            if (!($flag = $newModelRegistryBusinessFacility->save())) {

                                break;
                            }
                        }
                    }

                    if ($flag) {

                        foreach ($data->registryBusinessHours as $registryBusinessHour) {

                            $newModelRegistryBusinessHourDay = new RegistryBusinessHour();
                            $newModelRegistryBusinessHourDay->registry_business_id = $model->id;
                            $newModelRegistryBusinessHourDay->unique_id = $registryBusinessHour->unique_id;
                            $newModelRegistryBusinessHourDay->day = $registryBusinessHour->day;
                            $newModelRegistryBusinessHourDay->is_open = $registryBusinessHour->is_open;
                            $newModelRegistryBusinessHourDay->open_at = $registryBusinessHour->open_at;
                            $newModelRegistryBusinessHourDay->close_at = $registryBusinessHour->close_at;

                            if (!($flag = $newModelRegistryBusinessHourDay->save())) {

                                break;
                            } else {

                                foreach ($registryBusinessHour->registryBusinessHourAdditionals as $registryBusinessHourAdditional) {

                                    $newModelRegistryBusinessHourAdditional = new RegistryBusinessHourAdditional();
                                    $newModelRegistryBusinessHourAdditional->unique_id = $registryBusinessHourAdditional->unique_id;
                                    $newModelRegistryBusinessHourAdditional->registry_business_hour_id = $newModelRegistryBusinessHourDay->id;
                                    $newModelRegistryBusinessHourAdditional->day = $registryBusinessHourAdditional->day;
                                    $newModelRegistryBusinessHourAdditional->is_open = $registryBusinessHourAdditional->is_open;
                                    $newModelRegistryBusinessHourAdditional->open_at = $registryBusinessHourAdditional->open_at;
                                    $newModelRegistryBusinessHourAdditional->close_at = $registryBusinessHourAdditional->close_at;

                                    if (!($flag = $newModelRegistryBusinessHourAdditional->save())) {

                                        break 2;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {

                        foreach ($data->registryBusinessImages as $i => $registryBusinessImage) {

                            $i++;

                            $newModelRegistryBusinessImage = new RegistryBusinessImage();
                            $newModelRegistryBusinessImage->registry_business_id = $model->id;
                            $newModelRegistryBusinessImage->image = $registryBusinessImage->image;
                            $newModelRegistryBusinessImage->type = 'Gallery';
                            $newModelRegistryBusinessImage->category = 'Ambience';
                            $newModelRegistryBusinessImage->order = $i;

                            if (!($flag = $newModelRegistryBusinessImage->save())) {

                                break;
                            }
                        }
                    }

                    if ($flag) {

                        if (!empty($data->registryBusinessContactPeople)) {

                            foreach ($data->registryBusinessContactPeople as $i => $registryBusinessContactPerson) {

                                $newModelPerson = new Person();
                                $newModelPerson->first_name = $registryBusinessContactPerson->first_name;
                                $newModelPerson->last_name = $registryBusinessContactPerson->last_name;
                                $newModelPerson->phone = $registryBusinessContactPerson->phone;
                                $newModelPerson->email = $registryBusinessContactPerson->email;

                                if (!($flag = $newModelPerson->save())) {

                                    break;
                                } else {

                                    $newModelRegistryBusinessContactPerson = new RegistryBusinessContactPerson();
                                    $newModelRegistryBusinessContactPerson->registry_business_id = $model->id;
                                    $newModelRegistryBusinessContactPerson->person_id = $newModelPerson->id;
                                    $newModelRegistryBusinessContactPerson->is_primary_contact = $registryBusinessContactPerson->is_primary_contact;
                                    $newModelRegistryBusinessContactPerson->note = $registryBusinessContactPerson->note;
                                    $newModelRegistryBusinessContactPerson->position = $registryBusinessContactPerson->position;

                                    if (!($flag = $newModelRegistryBusinessContactPerson->save())) {

                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {

                        if (!empty($data->registryBusinessPayments)) {

                            foreach ($data->registryBusinessPayments as $registryBusinessPayment) {

                                $newModelRegistryBusinessPayment = new RegistryBusinessPayment();
                                $newModelRegistryBusinessPayment->registry_business_id = $model->id;
                                $newModelRegistryBusinessPayment->payment_method_id = $registryBusinessPayment->payment_method_id;
                                $newModelRegistryBusinessPayment->is_active = true;
                                $newModelRegistryBusinessPayment->note = $registryBusinessPayment->note;
                                $newModelRegistryBusinessPayment->description = $registryBusinessPayment->description;

                                if (!($flag = $newModelRegistryBusinessPayment->save())) {

                                    break;
                                }
                            }
                        }
                    }

                    if ($flag) {

                        if (!empty($data->registryBusinessDeliveries)) {

                            foreach ($data->registryBusinessDeliveries as $registryBusinessDelivery) {

                                $newModelRegistryBusinessDelivery = new RegistryBusinessDelivery();
                                $newModelRegistryBusinessDelivery->registry_business_id = $model->id;
                                $newModelRegistryBusinessDelivery->delivery_method_id = $registryBusinessDelivery->delivery_method_id;
                                $newModelRegistryBusinessDelivery->is_active = true;
                                $newModelRegistryBusinessDelivery->note = $registryBusinessDelivery->note;
                                $newModelRegistryBusinessDelivery->description = $registryBusinessDelivery->description;

                                if (!($flag = $newModelRegistryBusinessDelivery->save())) {

                                    break;
                                }
                            }
                        }
                    }
                }
            }

            if (!$flag) {

                break;
            } else {

                $content .= $data->name . '<br>';
            }
        }


        if ($flag) {

            $content .= "Berhasil<br>";

            $transaction->commit();
        } else {

            $content = print_r($model);

            $transaction->rollBack();
        }

        foreach ($restoreData as $data) {

            $content .= $data->name . '<br>';
        }

        return $this->renderContent($content);
    }
}
