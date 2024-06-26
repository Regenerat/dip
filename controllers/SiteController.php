<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\SignupForm;

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
            return $this->redirect(['orders/index']); // Перенаправление на страницу заказов
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
{
    $model = new SignupForm();

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        $user = new User();
        $user->login = $model->login;
        $user->password = $model->password; // Не шифруем пароль
        $user->email = $model->email;
        $user->phone = $model->phone;

        if ($user->save()) {
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно!');
            return $this->goHome(); // Перенаправляем пользователя после успешной регистрации
        } else {
            Yii::$app->session->setFlash('error', 'Произошла ошибка при регистрации.');
        }
    }

    return $this->render('signup', [
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
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('site-about');
    }

    public function actionContactInfo()
    {
        return $this->render('contact-info');
    }

    public function actionRegister() {
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setPassword($model->password);
            if ($model->save()) {
                return $this->redirect(['site/index']);
            }
        }
        return $this->render('register', ['model' => $model]);
    }
}
