<?php
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Настройки пользователя ' . $user->username;
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 w-50">
            <h4>Настройки пользователя <a href="<?= Url::toRoute(['site/by_user', 'id'=>$user->id]) ?>"><?= $user->username ?></a></h4>
            <div class="container">
                <?php $form = ActiveForm::begin(['id' => 'username-form', 'action' => ['site/user_settings', 'id' => $user->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($user, 'username')->textInput(['class' => 'form-control', 'value' => $user->username]) ?>
                    <?= Html::submitButton('Изменить', ['class' => 'mt-3 w-100 btn btn-primary', 'name' => 'username-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="container">
                <?php $form = ActiveForm::begin(['id' => 'email-form', 'action' => ['site/user_settings', 'id' => $user->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?= $form->field($user, 'email')->textInput(['type' => 'email', 'class' => 'form-control', 'value' => $user->email]) ?>
                <?= Html::submitButton('Изменить', ['class' => 'mt-3 w-100 btn btn-primary', 'name' => 'email-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="container">
                <?php $form = ActiveForm::begin(['id' => 'password-form', 'action' => ['site/user_settings', 'id' => $user->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?= $form->field($user, 'password')->passwordInput() ?>
                <?= $form->field($user, 'password')->passwordInput() ?>
                <?= $form->field($user, 'password')->passwordInput() ?>
                <?= Html::submitButton('Изменить', ['class' => 'mt-3 w-100 btn btn-primary', 'name' => 'password-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
