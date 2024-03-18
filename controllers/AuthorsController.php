<?php
namespace app\controllers;
use app\models\Authors;
use yii\data\ActiveDataProvider;
use Yii;

class AuthorsController extends \yii\web\Controller
{
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->isGuest) 
        {
            $author = Authors::findOne($id);

            if ($author) {
                if ($author->load(Yii::$app->request->post())) {
                    if ($author->save()) {
                        Yii::$app->session->setFlash('success', 'Изменено');
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка');
                    }
                }
            }

            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionDelete($id)
    {
        if (!Yii::$app->user->isGuest) 
        {
            $author = Authors::findOne($id);

            if ($author) {
                $dataProvider = new ActiveDataProvider([
                    'query' => $author->getBooks(),
                ]);

                foreach ($dataProvider->models as $book) {
                    if ($book->image) {
                        $img = $book->image;
                        $imgThumb = $book->thumbnail;
                        if (file_exists($img) && file_exists($imgThumb)) {
                            unlink($img);
                            unlink($imgThumb);
                        }
                    }

                    $book->delete();
                }
                $author->delete();

                Yii::$app->session->setFlash('error', 'Автор ' . $author->name . ' с его книгами удален.');
            }
            return $this->redirect(['/authors']);
        }
    }
}