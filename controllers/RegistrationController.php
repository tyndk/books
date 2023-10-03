<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\RegistrationForm;

class RegistrationController extends Controller
{
    public function actionRegister()
    {
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post() && $model->register())) {
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('/site/register', ['model' => $model]);
    }
}