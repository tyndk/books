<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';
?>

<div class="container mt-3 w-25 m-auto">
    <h2 class="mb-3">Регистрация</h2>
    <?php $form=ActiveForm::begin(['id' => 'registration-form', 'action' => ['registartion/register']]); ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>