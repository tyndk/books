<?php
namespace app\widgets;

use yii\base\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

class FormBookWidget extends Widget
{
    public $model;
    public $authors;
    public $genres;

    public function run()
    {
        $form = ActiveForm::begin([
            'id' => 'book-form',
            'action' => ['books/add'],
            'options' => ['enctype' => 'multipart/form-data']
        ]);
        ?>
        <?= $form->field($this->model, 'author_id')->dropDownList($this->authors, ['class' => 'form-control', 'list' => 'authors']) ?>
        <datalist id='authors'>
            <?php foreach ($this->authors as $item) : ?>
                <option value="<?= $item->name ?>"></option>
            <?php endforeach; ?>
        </datalist>
        <?= $form->field($this->model, 'title')->textInput(['class' => 'form-control']) ?>
        <?= $form->field($this->model, 'year')->input('number', ['class' => 'form-control']) ?>
        <?= $form->field($this->model, 'genre')->dropDownList($this->genres, ['class' => 'form-control']) ?>
        <?= $form->field($this->model, 'image')->fileInput(['class' => 'form-control']) ?>
        <?= $form->field($this->model, 'pages')->input('number', ['class' => 'form-control']) ?>
        <?= Html::submitButton('Добавить', ['class' => 'mt-3 w-100 btn btn-primary', 'name' => 'book-button']) ?>
        <?php ActiveForm::end();
    }
}