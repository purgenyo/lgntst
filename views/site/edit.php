<?php
/**
 * @var $model app\models\User
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="site-login">
    <h1><?=Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'edit-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
           # 'template' => "{label}\n<div class=\"col-lg-5\">{input}</div><div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
    ]);


    ?>

    <?= $form->field($model, 'username')->textInput(['disabled' => true]) ?>
    <?= $form->field($model, 'first_name')->textInput() ?>
    <?= $form->field($model, 'last_name')->textInput() ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary col-lg-3', 'name' => 'login-button']) ?>

    <?php ActiveForm::end(); ?>

</div>
