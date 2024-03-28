<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Главная страница';

$default_img = 'uploads/default.png';
?>
<div class="site-index">
    <div class="container mt-5">
        <h1 class="display-4">Добро пожаловать на тестовый сайт "Библиотека"</h1>
        <p class="lead">На этом сайте вы можете управлять книгами и авторами:</p>
        <ul class="lead">
            <li>Добавлять, редактировать и удалять книги, авторов (CRUD операции).</li>
            <li>Добавление и изменение записей доступно после регистрации.</li>
        </ul>
        <p class="lead">Главные ссылки указаны в шапке сайта.</p>
    </div>
</div>

<div class="container">
    <h1 class="mt-5 mb-4">Новинки книг</h1>

    <div class="row">
        <?php foreach ($books as $el) {
            if ($el->thumbnail) {
                $image = $el->thumbnail;
                $image_link = $image;
            } else {
                $image_link = $default_img;
            };
            ?>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <img class="card-img-top" class="img-fluid rounded" src="<?= $image_link ?>" alt="<?= $el->title ?>">
                <div class="card-body">
                    <h4 class="card-title"><a href="<?= Url::toRoute(['books/view', 'id'=>$el->id]) ?>"><?= $el->title ?></a></h4>
                    <p class="card-text"><a href="<?= Url::toRoute(['books/by_author', 'id'=>$el->author->id]) ?>"> <?= $el->author->name ?></a></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>