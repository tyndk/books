<?php

/** @var yii\web\View $this */

use yii\helpers\Url;
use app\models\User;

$users = User::find()->all();
$this->title = 'Список пользователей';
?>
<div class="site-index">
    <div class="container mt-5">
        <h3 class="px-3">Список пользователей</h3>
        <ul class="lead">
            <?php 
            foreach($users as $el) { ?>
                <li class="list-group-item">
                    <a href="<?= Url::toRoute(['site/by_users', 'id'=>$el->id]) ?>"><?= $el->username ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
