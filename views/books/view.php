<?php
/** @var yii\web\View $this */
/** @var app\models\Books $model */
/** @var app\models\Authors $author */
/** @var app\models\Comments $comment */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use app\models\Comments;
use app\models\User;

$default_img = 'uploads/default.png';
if ($model->thumbnail) {
  $image = $model->thumbnail; 
  $image_link = $image;
} else {
  $image_link = $default_img;
};

$this->title = 'Книга ' . $model->title;
$comments = Comments::find()->where(['book_id' => $model->id])->all(); //find()->all();
?>

<h3 class="px-3 mt-5 mb-3">Просмотр книги</h3>
<div class="card mx-3 mb-3" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4 p-3 bg-secondary text-center">
        <img src="<?= $image_link; ?>" class="img-fluid rounded" alt="<?= $model->title ?>">
        <?php if ($image_link != $default_img) { ?>
        <a href="<?= Url::toRoute(['delete_img', 'id'=>$model->id]) ?>"><button class="btn btn-secondary btn-sm">Удалить картинку</button></a>
        <?php } ?>
        <hr>
      <p class="card-text text-center"><small class="text-white">Страниц: <?php if ($model->pages) {echo $model->pages;} else {echo '(не задано)';} ?></small></p> 
    </div>
    <div class="col-md-8 pb-3">
      <div class="card-body">
        <h5 class="card-title">"<?= Html::encode($model->title) ?>"</h5>
        <p class="card-text">Эту книгу написал <b><a href="<?= Url::toRoute(['by_author', 'id'=>$model->author_id]) ?>"><?= $model->author->name ?></a></b> в <b><?php if ($model->year) {echo $model->year;} else {echo 'каком-то';} ?></b> году.</p>
        <p class="card-text">Жанр: <b><?= $model->genre ?></b></p>

        <?php if (!Yii::$app->user->isGuest)
        { ?>
        <a href="<?= Url::toRoute(['update', 'id'=>$model->id]) ?>"><button class="btn btn-primary">Изменить</button></a>
        <a href="<?= Url::toRoute(['delete', 'id'=>$model->id]) ?>"><button class="btn btn-danger">Удалить</button></a>
        <?php } ?>
          <div class="row m-2 mt-5">
              <a href="<?= Url::toRoute(['read', 'id'=>$model->id]) ?>">Читать</a>
          </div>
     </div>
    </div>
  </div>
</div>

<!--<div class="row px-3 mt-3 justify-content-center">-->
<!--    <div class="col-lg-12">-->
<!--        <p>-->
<!--        </p>-->
<!--    </div>-->
<!--</div>-->
<!--</div>-->
<div class="card bg-light">
    <div class="card-body">
        <h3>Комментарий:</h3>
            <?php $form = ActiveForm::begin(['id' => 'comment-form', 'action' => ['comments/add', 'id' => $model->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
            <?= $form->field($comment, 'text')->textarea(['class' => 'form-control', 'rows' => '3', 'value' => $comment->text, 'placeholder' => 'Введите комментарий...'])->label(false)  ?>
            <?= Html::submitButton('Добавить', ['class' => 'mb-3 w-100 btn btn-primary', 'name' => 'comment-button']) ?>
            <?php ActiveForm::end(); ?>
        <?php foreach($comments as $el) { ?>
        <div class="d-flex mb-4">
            <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..."></div>
            <div class="ms-3 w-100">
                <h5><?= User::findIdentity($el->user_id)->username ?></h5>
                <p id="commentText"><?= $el->text ?></p>
                <i style="font-size:12px;"><?= $el->timestamp ?></i> <!-- Время комментария: -->
            </div>
            <div class="d-flex align-self-center px-3">
                <?php if (Yii::$app->user->identity->id == $el->user_id) { ?>
                <a href="<?= Url::toRoute(['comments/delete', 'id'=>$el->id]) ?>"><button class="btn btn-sm btn-danger">Удалить</button></a>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>