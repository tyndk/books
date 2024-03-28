<?php
namespace app\controllers;
use app\models\Authors;
use app\models\Books;
use app\models\User;
use app\models\Comments;
use yii\data\ActiveDataProvider;
use Yii;


class CommentsController extends \yii\web\Controller
{
    public function actionAdd($id)
    {
        $comment = new Comments();

        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->request->isPost) {
                $model = Books::findOne($id);
                $user = User::findByUsername(Yii::$app->user->identity->username);

                $comment->book_id = $model->id;
                $comment->user_id = $user->id;
                $comment->timestamp = date('Y-m-d H:i:s');

                if ($comment->load(Yii::$app->request->post()) && $comment->validate()) {
                    $comment->save();
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionView($id)
    {

    }

    public function actionDelete($id)
    {
        $comment = Comments::findOne($id);

        if ($comment) {
            $comment->delete();
            Yii::$app->session->setFlash('success', 'Комментарий удален.');
        }
        else {
            Yii::$app->session->setFlash('error', 'Комментарий не найден.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdate($id)
    {
        $comment = Comments::findOne($id);

        if ($comment) {
            if ($comment->load(Yii::$app->request->post())) {
                if ($comment->save()) {
                    Yii::$app->session->setFlash('success', 'Изменено');
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка');
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}