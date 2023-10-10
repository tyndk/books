<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistrationForm;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();//goBack();
        }

        return $this->render('auth', [
            'model' => $model,
        ]);

    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    // /**
    //  * Displays contact page.
    //  *
    //  * @return Response|string
    //  */
    // public function actionContact()
    // {
    //     $model = new ContactForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
    //         Yii::$app->session->setFlash('contactFormSubmitted');

    //         return $this->refresh();
    //     }
    //     return $this->render('contact', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Displays books page.
     *
     * @return string
     */
    public function actionBooks()
    {
        return $this->render('..\books\books');
    }

    public function actionReg()
    {
        $model = new RegistrationForm();
        $user = new User();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->username = $model->username;
            //var_dump($model->username); exit;
            $user->email = $model->email;
            $user->password = Yii::$app->security->generatePasswordHash($model->password);

            if ($user->save()) {
                Yii::$app->user->login($user);
                Yii::$app->session->setFlash('success', 'Добро пожаловать, ' . $user->username . '!');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при регистрации: ' . implode(', ', array_values($model->getFirstErrors())));
            }

        }

        return $this->render('register', ['model' => $model]);
    }

    public function actionAuth()
    {
        $model = new RegistrationForm();
        
        return $this->render('auth', ['model' => $model]);
    }
}
