<?php
use app\models\Authors;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

$book = $model->id;

// Используем ActiveDataProvider для получения книг этого автора
$dataProvider = new ActiveDataProvider([
    'query' => Authors::findOne($model)->getBooks(), // Получаем связанные книги автора
]);
?>

<h2>Все книги <?= $model->author->name ?></h2>

<div class="row row-cols-1 row-cols-md-5 g-4">
<?php
foreach ($dataProvider->models as $book) { ?>
 <div class="col">
    <div class="card h-100">
        <img src="../uploads/<?= $book->image ?>" class="img-fluid rounded-start" alt="<?= $book->title ?>">
        <div class="card-body">
            <h5 class="card-title">
                <a href="<?= Url::toRoute(['view', 'id'=>$model->id]) ?>"><?= $book->title ?></a>
            </h5>
        </div>
    </div>
 </div>
<?php } ?>
</div>


