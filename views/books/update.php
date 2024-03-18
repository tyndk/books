<?php
/** @var yii\web\View $this */
/** @var app\models\Authors $author */
/** @var app\models\Books $model */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\models\Authors;

$authors = Authors::find()->all();
$authors_el = [];
foreach ($authors as $el) {
    $authors_el[$el->id] = $el->name;
}

?>

<h3 class="px-3">Изменение записи</h3>
<div class="container px-3 mt-3 col-md-3">
<?php $form = ActiveForm::begin(['id' => 'book-form', 'action' => ['books/update', 'id' => $model->id], 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'author_id')->dropDownList($authors_el) ?>
    <datalist id='authors'>
        <?php foreach ($authors as $item) : ?>
            <option value="<?= $item->name ?>"></option>
        <?php endforeach; ?>
    </datalist>
    <?= $form->field($model, 'title')->textInput(['class' => 'form-control', 'value' => $model->title]) ?>
    <?= $form->field($model, 'year')->input('number', ['class' => 'form-control', 'value' => $model->year]) ?>
    <?= $form->field($model, 'genre')->dropDownList(Yii::$app->GenresArray->genres) ?>
    <?= $form->field($model, 'image')->fileInput(['class' => 'form-control']) ?>
    <?= $form->field($model, 'pages')->input('number', ['class' => 'form-control', 'value' => $model->pages]) ?>
    <?= Html::submitButton('Изменить', ['class' => 'mt-3 w-100 btn btn-primary', 'name' => 'book-button']) ?>
<?php ActiveForm::end(); ?>
</div>