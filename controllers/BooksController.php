<?php

namespace app\controllers;
use app\models\Books;
use app\models\BooksSearch;
use app\models\Authors;
use yii\helpers\ArrayHelper; // Импорт класса ArrayHelper
use PharIo\Manifest\Author;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BooksController extends \yii\web\Controller
{


    private function uploadImage($model) 
    {
        $model->image = UploadedFile::getInstance($model, 'image');

        if ($model->save() && $model->image)
        {
            $imagePath = 'uploads/' . $model->image->baseName . '.' . $model->image->extension;
            
            if ($model->image->saveAs($imagePath))
            {
                $model->image = null;
                
                return $imagePath;
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Ошибка при загрузке картинки: '. implode(', ', array_values($model->getFirsErrors())));
            }
        }

        return null;
    }



    public function actionList()
    {
        $model = new Books();
        $el = Books::find()->all();
        $author = new Authors();

        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'model' => $model,
            'books' => $el,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'author' => $author,
        ]);
        
    }

    public function actionAdd()
    {
        $model = new Books();
        $authors = Authors::find()->all();

        //$author = Authors::findOne($id); //new Authors();

        if (Yii::$app->request->isPost) 
        {
            if ($model->load(Yii::$app->request->post())) // && $model->validate())// && $author->load(Yii::$app->request->post()))
            {
                $selectedAuthorId = Yii::$app->request->post('Books')['author_id'];
                $author = Authors::findOne($selectedAuthorId);

                if ($author)
                {
                    $model->author_id = $author->id;            

                    $imagePath = $this->uploadImage($model);

                    if ($imagePath !== null)
                    {
                        Yii::$app->session->setFlash('success', 'Книга добавлена');
                        return $this->redirect(['/books']);
                    }
                    else
                    {
                        Yii::$app->session->setFlash('error', 'Ошибка при сохранении книги: '. implode(', ', array_values($model->getFirstErrors())));
                        return $this->redirect(['/books']);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Выбранный автор не найден.');
                    return $this->redirect(['/books']);
                }
            }
        } 
        else
        {
        $el = Books::find()->all();

        return $this->render('list', [
            'model' => $model,
            'books' => $el,
            'authors' => $authors
        ]);
        }
    }

    public function actionView($id)
    {
        $model = Books::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Запись не найдена :(');
        }

        return $this->render('view', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Books::findOne($id);
        $model->delete();

        return $this->redirect(['/books']); //(Yii::$app->request->referrer);
    }

    public function actionUpdate($id)
    {
        $model = Books::findOne($id);
        $author= Authors::findOne($model->author_id);//$model->author->name;

        if (!$model)
        {
            throw new NotFoundHttpException('Запись не найдена :(');
        }
        else if ($model->load(Yii::$app->request->post()) && $author->load(Yii::$app->request->post()))
        {
            $author->save();
            $model->author_id = $author->id;
            $imagePath = $this->uploadImage($model);

            if ($imagePath !== null)
            {
                Yii::$app->session->setFlash('success', 'Книга изменена');
                return $this->redirect('books');
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Ошибка при обновлении книги: '. implode(', ', array_values($model->getFirsErrors())));
            }
        }

        return $this->render('update', [
            'model' => $model, 
            'author' => $author
        ]);
    }

    public function actionBy_author($id)
    {
        $model = Books::findOne($id);
        $author = $model->author->name;

        return $this->render('by_author', [
            'model' => $model,
            'author' => $author
            ]);
    }

    public function actionAuthors()
    {
        $author = new Authors();

        if (Yii::$app->request->isPost) 
        {
            if ($author->load(Yii::$app->request->post()))
            {
                $authorName = $author->name;
                $author->save();
                return $this->redirect(['/books']);
            }
        }

        return $this->render('authors', [
            'author' => $author
            ]);
    }
}
