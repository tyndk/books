<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\Books $model */
/** @var app\models\Books[] $books */
/** @var app\models\Authors $author */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\data\ActiveDataProvider;
use app\models\Books;
use app\models\BooksSearch;
use app\models\Authors;
use yii\grid\GridView;

$this->title = 'Список книг';

$authors = Authors::find()->all();
$authors_el = [];
foreach ($authors as $el) {
    $authors_el[$el->id] = $el->name;
}

?>
<div class="site-about">
   
<?php if (!Yii::$app->user->isGuest) 
        { ?>
<div class="collapse" id="navbarToggleExternalContent" data-bs-theme="secondary">
  <div class="bg-secondary p-4 rounded w-75 m-auto">
    <div class="container px-3 py-1">
        <h3 class="px-3">Введите запись</h3><hr>
    </div>
    <div class="container px-3 mt-3 col-md-4">
    <?php $form = ActiveForm::begin(['id' => 'book-form', 'action' => ['books/add'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'author_id')->dropDownList($authors_el) ?>
    <datalist id='authors'>
        <?php foreach ($authors as $item) : ?>
            <option value="<?= $item->name ?>"></option>
        <?php endforeach; ?>
    </datalist>
    <?= $form->field($model, 'title')->textInput(['class' => 'form-control']) ?>
    <?= $form->field($model, 'year')->input('number', ['class' => 'form-control']) ?>
    <?= $form->field($model, 'genre')->dropDownList(Yii::$app->GenresArray->genres, ['class' => 'form-control']) ?>
    <?= $form->field($model, 'image')->fileInput(['class' => 'form-control']) ?>
    <?= $form->field($model, 'pages')->input('number', ['class' => 'form-control']) ?>
    <?= Html::submitButton('Добавить', ['class' => 'mt-3 w-100 btn btn-primary', 'name' => 'book-button']) ?>
    <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>

<nav class="navbar navbar-secondary bg-white rounded mt-3">
  <div class="container-fluid justify-content-center rounded">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      Добавление книги
    </button>
  </div>
</nav>
<?php } else { ?>
    <div class="alert alert-primary" role="alert">
        Чтобы добавить книги авторизуйтесь.
    </div>
<?php } ?>

<div class="container mt-5">
<h2>Все записи: </h2>
    <?php
    $grid = GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'author_id',
                'value' => function ($model) {
                    return $model->author->name;
                },
                'filter' => Html::activeTextInput($searchModel, 'author', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'title',
                'filter' => Html::activeTextInput($searchModel, 'title', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'year',
                'filter' => Html::activeTextInput($searchModel, 'year', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'genre',
                'filter' => Html::activeTextInput($searchModel, 'genre', ['class' => 'form-control']),
            ],
            [
                'attribute' => 'pages',
                'filter' => Html::activeTextInput($searchModel, 'pages', ['class' => 'form-control']),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'visibleButtons' => [
                    'update' => !Yii::$app->user->isGuest,
                    'delete' => !Yii::$app->user->isGuest
                    ]
            ],
        ],
        'pager' => [
            'options' => ['class' => 'pagination justify-content-center m-3'],  
            'linkOptions' => ['class' => 'page-link m-1 rounded'],  
          ],
    ]);
        echo $grid;
    ?>
</div>
</div>
