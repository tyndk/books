<?php
/** @var yii\web\View $this */
/** @var app\models\Books $model */
/** @var app\models\Authors $author */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Читать книгу ' . $model->title;
?>

<h3 class="px-3 mt-5 mb-3">Книга <a href="<?= Url::toRoute(['view', 'id'=>$model->id]) ?>"><?= $model->title ?></a></h3></h3><hr>
<div class="row px-3 mt-3 justify-content-center">
    <div class="col-lg-12 bg-light">
        <p>
            <?php echo $currentPageText; ?>
        </p>
        <?php echo LinkPager::widget([
            'pagination' => $pagination,
            'options' => [
                    'class' => 'pagination justify-content-center',
            ],
            'linkOptions' => ['class' => 'page-link'],
            'maxButtonCount' => 5,
            'prevPageLabel' => false,
            'nextPageLabel' => false,
            ]); ?>
    </div>
</div>