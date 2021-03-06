<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= '\'Update \' . Yii::t(\'app\', ' . $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) . ') . \' : \'' ?> . $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= 'Yii::t(\'app\', ' . $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) . ')' ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => ['view', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Update') ?>;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">

    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
