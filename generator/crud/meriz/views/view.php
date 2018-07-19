<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use sycomponent\AjaxRequest;
use sycomponent\ModalDialog;
use sycomponent\NotificationDialog;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$ajaxRequest = new AjaxRequest([
    'modelClass' => '<?= StringHelper::basename($generator->modelClass) ?>',
]);

$ajaxRequest->view();

$status = Yii::$app->session->getFlash('status');
$message1 = Yii::$app->session->getFlash('message1');
$message2 = Yii::$app->session->getFlash('message2');

if ($status !== null) :
    $notif = new NotificationDialog([
        'status' => $status,
        'message1' => $message1,
        'message2' => $message2,
    ]);

    $notif->theScript();
    echo $notif->renderDialog();

endif;

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= 'Yii::t(\'app\', ' . $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) . ')' ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; ?>

<?= '<?=' ?> $ajaxRequest->component() ?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <div class="row">
        <div class="col-sm-12">
            <div class="x_panel">

                <div class="x_content">

                    <?= "<?= " ?>Html::a('<i class="fa fa-upload"></i> ' . <?= $generator->generateString('Create') ?>,
                        ['create'],
                        [
                            'class' => 'btn btn-success',
                            'style' => 'color:white'
                        ]) ?>

                    <?= "<?= " ?>Html::a('<i class="fa fa-pencil-alt"></i> ' . <?= $generator->generateString('Edit') ?>,
                        ['update', <?= $urlParams ?>],
                        [
                            'class' => 'btn btn-primary',
                            'style' => 'color:white'
                        ]) ?>

                    <?= "<?= " ?>Html::a('<i class="fa fa-trash-alt"></i> ' . <?= $generator->generateString('Delete') ?>,
                        ['delete', <?= $urlParams ?>],
                        [
                            'id' => 'delete',
                            'class' => 'btn btn-danger',
                            'style' => 'color:white',
                            'data-not-ajax' => 1,
                            'model-id' => $model->id,
                            'model-name' => $model->name,
                        ]) ?>

                    <?= "<?= " ?>Html::a('<i class="fa fa-times"></i> ' . <?= $generator->generateString('Cancel') ?>,
                        ['index'],
                        [
                            'class' => 'btn btn-default',
                        ]) ?>

                    <div class="clearfix" style="margin-top: 15px"></div>

                    <?= "<?= " ?>DetailView::widget([
                        'model' => $model,
                        'options' => [
                            'class' => 'table'
                        ],
                        'attributes' => [
                            <?php
                            if (($tableSchema = $generator->getTableSchema()) === false) {
                                foreach ($generator->getColumnNames() as $name) {
                                    echo "            '" . $name . "',\n";
                                }
                            } else {
                                foreach ($generator->getTableSchema()->columns as $column) {
                                    $format = $generator->generateColumnFormat($column);
                                    echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                                }
                            }
                            ?>
                        ],
                    ]) ?>

                </div>

            </div>
        </div>
    </div>

</div>

<?= "<?php\n" ?>

$modalDialog = new ModalDialog([
    'clickedComponent' => 'a#delete',
    'modelAttributeId' => 'model-id',
    'modelAttributeName' => 'model-name',
]);

$modalDialog->theScript(false);

echo $modalDialog->renderDialog();

?>