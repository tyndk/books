<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var app\models\Authors $author
 * @var yii\data\ActiveDataProvider $dataProvider
 */
$this->title = 'Все книги ' . $author->name;
$default_img = 'default.png';
?>

<div class="d-flex justify-content-start">
        <h2>Все книги <b id="headingAuthor"><?= Html::encode($author->name) ?></b></h2>
        <div class="form-group d-flex">
            <?php $form = ActiveForm::begin(['id' => 'formUpdate', 'action' => ['authors/update', 'id' => $author->id], 'options' => ['class' => 'd-none m-1']]); ?>
                <?= $form->field($author, 'name')->textInput(['placeholder' => $author->getAttributeLabel('name')])->label(false) ?>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-sm']) ?>
            <?php ActiveForm::end(); ?>
            </div>

    <?php if (!Yii::$app->user->isGuest) 
        { ?>
        <div class="p-2">
            <button  id="editButton" class="btn btn-primary btn-sm">Изменить</button>
            <button  id="cancelButton" class="btn btn-danger btn-sm d-none">Отменить</button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Удалить</button>
        </div>
  <?php } ?>
</div>

<div class="row row-cols-1 row-cols-md-5 g-4">
<?php
foreach ($dataProvider->models as $book) { 
  if ($book->thumbnail) {
    $image = $book->thumbnail; 
    $image_link = $image;
  } else {
    $image_link = 'uploads/' . $default_img;
  };
  ?>
 <div class="col">
    <div class="card h-100">
        <img src="../<?= $image_link ?>" class="img-fluid rounded" alt="<?= $book->title ?>">
        <div class="card-body">
            <h5 class="card-title">
                <a href="<?= Url::toRoute(['view', 'id'=>$book->id]) ?>"><?= $book->title ?></a>
            </h5>
        </div>
    </div>
 </div>
<?php } ?>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Внимание</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Удаление автора удалит и книги.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Отмена</button>
        <a href="<?= Url::toRoute(['/authors/delete', 'id'=>$author->id]) ?>"><button class="btn btn-danger btn-sm">Удалить</button></a>
      </div>
    </div>
  </div>
</div>

<script>
        document.getElementById('editButton').addEventListener('click', function() {
        document.getElementById('headingAuthor').classList.toggle('d-none');
        document.getElementById('formUpdate').classList.toggle('d-none');
        document.getElementById('editButton').classList.toggle('d-none');
        document.getElementById('cancelButton').classList.toggle('d-none');
    });

    document.getElementById('cancelButton').addEventListener('click', function() {
        document.getElementById('headingAuthor').classList.toggle('d-none');
        document.getElementById('formUpdate').classList.toggle('d-none');
        document.getElementById('editButton').classList.toggle('d-none');
        document.getElementById('cancelButton').classList.toggle('d-none');
    });
</script>