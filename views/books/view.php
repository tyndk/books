<?php
/** @var yii\web\View $this */
/** @var app\models\Books $model */
/** @var app\models\Authors $author */

use yii\helpers\Html;
use yii\helpers\Url;

$default_img = 'uploads/default.png';
if ($model->thumbnail) {
  $image = $model->thumbnail; 
  $image_link = $image;
} else {
  $image_link = $default_img;
};

$this->title = 'Книга ' . $model->title;
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

<div class="row px-3 mt-3 justify-content-center">
    <div class="col-lg-12">
        <p>

        </p>
    </div>
</div>
</div>
