<?php
/** @var app\models\Authors $author */

use app\models\Authors;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$authors = Authors::find()->all();
?>

<div class="bg-secondary p-4 rounded w-75 m-auto">
    <div class="container px-3 py-1">
        <h3 class="px-3">Добавьте автора</h3><hr>
    </div>
    <div class="container px-3 mt-3 col-md-4">
    <?php $form = ActiveForm::begin(['id' => 'book-form', 'action' => ['books/authors'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($author, 'name')->textInput(['class' => 'form-control', 'list' => 'authors']) ?>
    <?= Html::submitButton('Добавить', ['class' => 'mt-3 w-100 btn btn-primary', 'name' => 'book-button']) ?>
    <?php ActiveForm::end(); ?>
    </div>
</div>





