<?php
namespace app\controllers;
use app\models\Books;
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

            if ($author->load(Yii::$app->request->post()))
            {
                if ($author->save())
                {
                    Yii::$app->session->setFlash('success', 'Изменено');
                }
                else {
                    Yii::$app->session->setFlash('error', 'Ошибка');
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
            $dataProvider = new ActiveDataProvider([
                'query' => $author->getBooks(),
            ]);

            foreach ($dataProvider->models as $book) {
                $file = 'uploads/' . $book->image;
                if (file_exists($file))
                {
                    unlink($file);
                }
                $book->delete();
            }
            $author->delete();
            
            Yii::$app->session->setFlash('error', 'Автор ' . $author->name . ' с его книгами удален.');

            return $this->redirect(['/authors']);
        }
    }
}