<?php
/** @var app\models\Authors $author */

use app\models\Authors;
use app\models\Books;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$authors = Authors::find()->all();
// $model = Books::find()->all();
// $dataProvider = new ActiveDataProvider([
//     'query' => Authors::findOne($model)->getBooks(), // Получаем связанные книги автора
// ]);
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

<div class="container w-75 m-auto pt-5">
    <h3>Список авторов</h3>
    <ul class="list-group">
    <?php foreach($authors as $el) { ?>
        <li class="list-group-item">
            <a href="<?= Url::toRoute(['by_author', 'id'=>$el->id]) ?>"><?= $el->name ?></a>
        </li>
    <?php } ?>
    </ul>
</div>

