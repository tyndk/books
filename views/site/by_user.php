<?php

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Url;
use app\models\User;
use app\models\Comments;
use app\models\Books;

$this->title = 'Информация о пользователе ' . $user->username;
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <img src="avatar.jpg" class="img-fluid rounded-circle mb-3" alt="Аватар пользователя">
            <h3 class="px-3">Пользователь <?= $user->username ?></h3>
            <?php if (Yii::$app->user->identity->id == $user->id) { ?>
                <a href=" <?= Url::to(['user_settings', 'id' => $user->id]) ?>">Редактировать</a>
            <?php } ?>
        </div>
    <div class="col-md-8">
        <h4>Список комментариев <?= '<a href="' . Url::to(['by_users_allcomments', 'id' => $user->id]) . '">(все)</a>' ?></h4>
        <div class="card">
            <?php
            $comments = array_slice($dataProvider->models, 0, 3); //$dataProvider->models
            foreach($comments as $el) { ?>
            <div class="card-header">
                Книга: <b><a href="<?= Url::toRoute(['books/view', 'id'=>$el->book->id]) ?>"><?= $el->book->title ?></a></b>
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p><?= $el->text ?></p>
                    <i style="font-size:12px;"><?= $el->timestamp ?></i>
                </blockquote>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-5 g-4">
        <div class="col-md-12">
            <h4>Что рекомендует</h4>
        </div>
        <div class="col">
            <div class="card h-100">
                Картинка
                <div class="card-body">
                    <h5 class="card-title">
                        Книга заголовок
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
