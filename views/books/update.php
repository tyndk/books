<?php
/** @var yii\web\View $this */
/** @var app\models\Authors $author */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
?>

<h3 class="px-3">Изменение записи</h3>
<div class="container px-3 mt-3 col-md-3">
<?php $form = ActiveForm::begin(['id' => 'book-form', 'action' => ['books/update', 'id' => $model->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($author, 'name')->textInput(['class' => 'form-control', 'value' => $author->name]) ?>
    <?= $form->field($model, 'title')->textInput(['class' => 'form-control', 'value' => $model->title]) ?>
    <?= $form->field($model, 'year')->input('number', ['class' => 'form-control', 'value' => $model->year]) ?>
    <?= $form->field($model, 'genre')->textInput(['class' => 'form-control', 'value' => $model->genre]) ?>
    <?= $form->field($model, 'image')->fileInput(['class' => 'form-control', 'value' => $model->image]) ?>
    <?= $form->field($model, 'pages')->input('number', ['class' => 'form-control', 'value' => $model->pages]) ?>
    <?= Html::submitButton('Изменить', ['class' => 'mt-3 w-100 btn btn-primary', 'name' => 'book-button']) ?>
<?php ActiveForm::end(); ?>
</div>