<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Books $model */

$this->title = 'Авторизация';
?>

<div class="container mt-3 w-25 m-auto">
    <h2 class="mb-3 text-center">Авторизация</h2>
    <div class="border p-3 rounded">
        <?php $form=ActiveForm::begin(['id' => 'auth-form', 'action' => ['site/login']]); ?>
        <?= $form->field($model, 'username')->textInput() ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <div class="form-group">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <p>Еще не зарегистрированы? <a href="reg">Зарегистрироваться</a></p>
    </div>
</div>