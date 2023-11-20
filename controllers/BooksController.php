<?php

namespace app\controllers;
use app\models\Books;
use app\models\BooksSearch;
use app\models\Authors;
use yii\helpers\ArrayHelper;
use PharIo\Manifest\Author;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\Html;

/** @var \app\models\Books|null $model */

class BooksController extends \yii\web\Controller
{

    private function uploadImage($model) 
    {
        $model->image = UploadedFile::getInstance($model, 'image');

        if ($model->image)
        {
            $imgPath = 'uploads/';
            $imgName = Yii::$app->security->generateRandomString(10);
            $fileExt = '.' . $model->image->extension;

            $originFile = $imgPath . $imgName . $fileExt;
            $thumbnFile = $imgPath . $imgName . '-thumb' . $fileExt;
            
            if ($model->image->saveAs($originFile))
            {
                Image::thumbnail($originFile, 200, 200)->save($thumbnFile, ['quality' => 80]);

                $model->image = $originFile;
                $model->thumbnail = $thumbnFile;

                if ($model->save()){
                    return $originFile;
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при загрузке картинки: '. implode(', ', array_values($model->getFirstErrors())));
                }
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Ошибка при загрузке картинки: '. implode(', ', array_values($model->getFirstErrors())));
            }
        }
        else
        {
            $model->save();
            return null;
        }

        return null;
    }



    public function actionList()
    {
        $model = new Books();
        $author = new Authors();

        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'author' => $author,
        ]);
        
    }

    public function actionAdd()
    {
        $model = new Books();
        $authors = Authors::find()->all();

        if (Yii::$app->request->isPost) 
        {
            if ($model->load(Yii::$app->request->post()))
            {
                $selectedAuthorId = Yii::$app->request->post('Books')['author_id'];
                $author = Authors::findOne($selectedAuthorId);

                if ($author)
                {
                    $model->author_id = $author->id;

                    $imagePath = $this->uploadImage($model);
                    
                    Yii::$app->session->setFlash('success', 'Книга добавлена');
                    return $this->redirect(['/books']);
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
        $file = 'uploads/' . $model->image;

        if (file_exists($file))
        {
            if (unlink($file))
            {
                Yii::$app->session->setFlash('success', 'Картинка ' . $file . ' книги удалена');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Картинки не нашлось для удаления');
        }

        $model->delete();

        return $this->redirect(['/books']);
    }

    
    public function actionUpdate($id)
    {
        $model = Books::findOne($id);
        $author= Authors::findOne($model->author_id);
        if ($model->image !== null) {
            $oldImage = $model->image;
            $oldImageThumb = $model->thumbnail;
        } else {
            $oldImage=null;
        }
        
        if (!$model)
        {
            throw new NotFoundHttpException('Запись не найдена :(');
        }
        else if ($model->load(Yii::$app->request->post()))
        {
            $selectedAuthorId = Yii::$app->request->post('Books')['author_id'];
            $author = Authors::findOne($selectedAuthorId);

            $model->author_id = $author->id;
            $imagePath = $this->uploadImage($model);
            
            if ($imagePath !== null)
            {
                if ($oldImage !== null) {
                    unlink($oldImage);
                    unlink($oldImageThumb);
                }
                Yii::$app->session->setFlash('success', 'Книга изменена');
                return $this->redirect('books');
            }
            else
            {
                return $this->redirect('books');
            }
        }

        if (!Yii::$app->user->isGuest) 
        {
            return $this->render('update', [
                'model' => $model, 
                'author' => $author
            ]);
        } else {
            return $this->goHome();
        }
    }

    public function actionBy_author($id)
    {
        $author = Authors::findOne($id);

        if ($author !== null) {
            $dataProvider = new ActiveDataProvider([
                'query' => $author->getBooks(),
            ]);
    
            return $this->render('by_author', [
                'dataProvider' => $dataProvider,
                'author' => $author,
            ]);
        } else {
            throw new NotFoundHttpException('Автор не найден.');
        }
    }

    public function actionAuthors()
    {
        $model = Books::find()->all();
        $author = new Authors();

        if (Yii::$app->request->isPost) 
        {
            if ($author->load(Yii::$app->request->post()) && $author->validate())
            {
                $authorName = strip_tags($author->name);
                $author->save();
                return $this->refresh();
            }
        }

        return $this->render('authors', [
            'model' => $model,
            'author' => $author
            ]);
    }
}
