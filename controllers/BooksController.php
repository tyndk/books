<?php

namespace app\controllers;
use app\models\Books;
use app\models\BooksSearch;
use app\models\Authors;
use app\models\Comments;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\imagine\Image;

/** @var \app\models\Books|null $model */

class BooksController extends \yii\web\Controller
{

    private function uploadImage($model)
    {
        if (!Yii::$app->user->isGuest) 
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
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Книга добавлена');
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при добавлении: '. implode(', ', array_values($model->getFirstErrors())));
                    return null;
                }
            }

            return null;
        }
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
        if (!Yii::$app->user->isGuest) 
        {
            $model = new Books();
            $authors = Authors::find()->all();

            if (!$authors) {
                throw new NotFoundHttpException('Авторы не найдены');
            }
    
            if (Yii::$app->request->isPost) 
            {
                if ($model->load(Yii::$app->request->post()))
                {
                    $selectedAuthorId = Yii::$app->request->post('Books')['author_id'];
                    $author = Authors::findOne($selectedAuthorId);

                    if ($author)
                    {
                        $model->author_id = $author->id;
                        $this->uploadImage($model);

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
        else
        {
            Yii::$app->session->setFlash('error', 'Нельзя, нужно зарегаться');
            return $this->redirect(['/books']);
        }
    }

    public function actionView($id)
    {
        $model = Books::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Запись не найдена :(');
        }

        $comment = new Comments();

        return $this->render('view', [
            'model' => $model,
            'comment' => $comment
        ]);
    }

    public function actionRead($id)
    {
        $model = Books::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Запись не найдена :(');
        }

        $text = $model->text;
        $words = explode(' ', $text);
        $pageSize = 500; // слов

        $pagination = new Pagination([
            'totalCount' => count($words),
            'pageSize' => $pageSize,
        ]);

        $words = array_slice($words, $pagination->offset, $pagination->limit);
        $currentPageText = implode(' ', $words);

        return $this->render('read', [
            'model' => $model,
            'currentPageText' => $currentPageText,
            'pagination' => $pagination,
            ]);
    }

    public function actionDelete($id)
    {
        if (!Yii::$app->user->isGuest) 
        {
            $model = Books::findOne($id);
            if ($model) {
                $originFile = $model->image;
                $thumbnFile = $model->thumbnail;

                if ($originFile !== null && file_exists($originFile))
                {
                    if ((unlink($originFile)) && (unlink($thumbnFile)))
                    {
                        Yii::$app->session->setFlash('success', 'Картинка книги удалена');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Картинки не нашлось для удаления');
                }

                if ($model->delete()){
                    Yii::$app->session->setFlash('success', 'Книга удалена');
                }
            }
            else {
                throw new \yii\web\NotFoundHttpException('Запись не найдена');
            }

            return $this->redirect(['/books']);
        }
    }

    
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->isGuest) 
        {
            $model = Books::findOne($id);

            if ($model) {

                $author = Authors::findOne($model->author_id);
                $oldImage = $model->image;
                $oldImageThumb = $model->thumbnail;

                if ($model->load(Yii::$app->request->post())) {
                    $selectedAuthorId = Yii::$app->request->post('Books')['author_id'];
                    $author = Authors::findOne($selectedAuthorId);

                    $model->author_id = $author->id;

                    $newImage = UploadedFile::getInstance($model, 'image');
                    if ($newImage == null) {
                        $model->image = $oldImage;
                        $model->thumbnail = $oldImageThumb;
                    } else {
                        $this->uploadImage($model);
                        if ($oldImage !== null && $oldImageThumb !== null) {
                            unlink($oldImage);
                            unlink($oldImageThumb);
                        }
                    }

                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Книга изменена');
                        return $this->redirect(['books/view', 'id' => $id]);
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка: ' . implode(', ', array_values($model->getFirstErrors())));
                        return $this->redirect(['books/view', 'id' => $id]);
                    }
                }
            }
            else
            {
                throw new NotFoundHttpException('Запись не найдена :(');
            }

                return $this->render('update', [
                'model' => $model, 
                'author' => $author
            ]);
        }
        else 
        {
            return $this->goHome();
        }
    }

    public function actionBy_author($id)
    {
        $author = Authors::findOne($id);

        if ($author) {
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
        $author = new Authors();

        if (!Yii::$app->user->isGuest) 
        {
            if (Yii::$app->request->isPost) 
            {
                if ($author->load(Yii::$app->request->post()) && $author->validate())
                {
                    $author->save();
                    //return $this->refresh();
                }
            }
        }
            return $this->render('authors', [
                'author' => $author
                ]);
        
    }

    public function actionDelete_img($id)
    {
        if (!Yii::$app->user->isGuest) 
        {
            $model = Books::findOne($id);
            if ($model) {
                $originFile = $model->image;
                $thumbnFile = $model->thumbnail;
            }
            else {
                throw new \yii\web\NotFoundHttpException('Картинка не найдена');
            }

            if ($originFile !== null && file_exists($originFile))
            {
                if ((unlink($originFile)) && (unlink($thumbnFile)))
                {
                    $model->image = NULL;
                    $model->thumbnail = NULL;
                    $model->save();
                    Yii::$app->session->setFlash('success', 'Картинка удалена');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Картинки не нашлось для удаления');
            }

            return $this->redirect(Yii::$app->request->referrer);
        }
    }
}
