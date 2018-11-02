<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use sycomponent\AjaxRequest;
use sycomponent\NotificationDialog;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

$ajaxRequest = new AjaxRequest([
    'modelClass' => '<?= StringHelper::basename($generator->modelClass) ?>',
]);

$ajaxRequest->form();

$status = Yii::$app->session->getFlash('status');
$message1 = Yii::$app->session->getFlash('message1');
$message2 = Yii::$app->session->getFlash('message2');

if ($status !== null) {
    $notif = new NotificationDialog([
        'status' => $status,
        'message1' => $message1,
        'message2' => $message2,
    ]);

    $notif->theScript();
    echo $notif->renderDialog();

} ?>

<?= '<?=' ?> $ajaxRequest->component() ?>

<div class="row">
    <div class="col-sm-12">
        <div class="x_panel">
            <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

                <?= "<?php " ?>$form = ActiveForm::begin([
                        'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form',
                        'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
                        'options' => [

                        ],
                        'fieldConfig' => [
                            'parts' => [
                                '{inputClass}' => 'col-lg-12'
                            ],
                            'template' => '
                                <div class="row">
                                    <div class="col-lg-3">
                                        {label}
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="{inputClass}">
                                            {input}
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        {error}
                                    </div>
                                </div>',
                        ]
                ]); ?>

                    <div class="x_title">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?= "<?php\n" ?>
                                    if (!$model->isNewRecord)
                                        echo Html::a('<i class="fa fa-upload"></i> ' . 'Create', ['create'], ['class' => 'btn btn-success']); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="x_content">

                    <?php foreach ($generator->getColumnNames() as $attribute) {
                        if (in_array($attribute, $safeAttributes)) {
                            echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
                        }
                    } ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <?= "<?php\n" ?>
                                    $icon = '<i class="fa fa-save"></i> ';
                                    echo Html::submitButton($model->isNewRecord ? $icon . <?= $generator->generateString('Save') ?> : $icon . <?= $generator->generateString('Update') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                                    echo Html::a('<i class="fa fa-times"></i> Cancel', ['index'], ['class' => 'btn btn-default']); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                <?= "<?php " ?>ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div><!-- /.row -->
