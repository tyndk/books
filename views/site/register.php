<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';
?>

<div class="container mt-3 w-25 m-auto">
    <h2 class="mb-3 text-center">Регистрация</h2>
        <div class="border p-3 rounded">
        <?php $form=ActiveForm::begin(['id' => 'registration-form', 'action' => ['site/reg']]); ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <div class="form-group">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <p>Уже зарегистрированы? <a href="login">Войти</a></p>
        </div>
</div>