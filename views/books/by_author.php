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

<?php
foreach ($dataProvider->models as $book) { ?>
    <ul>
        <li><a href="<?= Url::toRoute(['view', 'id'=>$model->id]) ?>"><?= $book->title ?></a></li>
    </ul>
<?php } ?>





