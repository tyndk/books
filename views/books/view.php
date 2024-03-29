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
?>

<div class="card mb-3" style="max-width: 540px;">
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
     </div>
    </div>
  </div>
</div>