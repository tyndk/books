<?php

namespace app\controllers;

use app\models\Authors;
use app\models\Books;
use app\models\Comments;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegistrationForm;
use app\models\User;

/**
 * @var \app\models\User username
 */

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
        $books = Books::find()->orderBy(['id' => SORT_DESC])->limit(4)->all(); //all();
        $authors = Authors::find()->all();

        return $this->render('index', [
            'books' => $books,
            'authors' => $authors,
        ]);
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
            return $this->goHome();
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

    /**
     * Displays books page.
     *
     * @return string
     */
    public function actionBooks()
    {
        return $this->render('..\books\books');
    }

    /**
     * @return string|Response
     * @throws \yii\base\Exception
     * @property string $user
     * @property User $username
     * @var $user \app\models\User
     */
    public function actionReg()
    {
        $model = new RegistrationForm();
        $user = new User();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->username = $model->username;
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

    public function actionUsers()
    {
        return $this->render('users');
    }

    public function actionBy_user($id)
    {
        $user = User::findOne($id);
        $books = Books::find()->all();
        //$comments = Comments::findAll(['id' => $user->id]);

        $query = $user->getComments()->with('book');

        if ($user){
            $dataProvider = new ActiveDataProvider([
                'query' => $query->orderBy(['timestamp' => SORT_DESC])->limit(3),
            ]);

        return $this->render('by_user', [
            'dataProvider' => $dataProvider,
            'user' => $user,
            'books' => $books,
        ]);
            } else {
        throw new NotFoundHttpException('Пользователь не найден.');
        }
    }

    public function actionBy_users_allcomments($id)
    {
        $user = User::findOne($id);

        if ($user){
            $dataProvider = new ActiveDataProvider([
                'query' => $user->getComments()->with('book'),
            ]);

        return $this->render('../user/all_comments', [
            'dataProvider' => $dataProvider,
            'user' => $user,
            ]);
        } else {
            throw new NotFoundHttpException('Пользователь не найден.');
        }
    }

    public function actionUser_settings($id)
    {
        $user = User::findOne($id); //Yii::$app->user->identity->id; //User::findOne($id);

        if ($user){
            if ($user->load(Yii::$app->request->post())) {

                if ($user->save()) {
                    Yii::$app->session->setFlash('success', 'Информация изменена');
                    return $this->redirect(['site/user_settings', 'id' => $id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка: ' . implode(', ', array_values($user->getFirstErrors())));
                    return $this->redirect(['site/user_settings', 'id' => $id]);
                }
            }
        }

        return $this->render('../user/user_settings', [
            'user' => $user,
        ]);
    }

    public function actionUser_password_update($id)
    {

    }
}
