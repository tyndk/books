<?php
use yii\helpers\Url;

$this->title = 'Все комментарии пользователя ' . $user->username;
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h4>Все комментарии пользователя <a href="<?= Url::toRoute(['site/by_users', 'id'=>$user->id]) ?>"><?= $user->username ?></a></h4>
            <div class="card">
                <?php foreach($dataProvider->models as $el) { ?>
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
    </div>
</div>
