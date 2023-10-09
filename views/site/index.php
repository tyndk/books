<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Books!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>
        <p>Авторизован - <?php //echo $nickname; ?>?</p>

        <p><a class="btn btn-lg btn-primary" href="<?= Url::toRoute('/books/list', $schema = true) ?>">Просмотр книг</a></p>
    </div>

</div>
