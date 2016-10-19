<?php

namespace app\controllers;

use app\components\MainController;
use app\models\SignUp;
use app\models\User;
use Yii;
use app\models\LoginForm;
use yii\base\Exception;
use yii\filters\VerbFilter;

class SiteController extends MainController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
            ]
        ];
        return $behaviors;
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
     *
     * Редактирование информации пользователя.
     *
     * @return string
     */
    public function actionEdit()
    {
        $model = new User();
        $model = $model->findIdentity(Yii::$app->user->id);
        $model->scenario = User::SCENARIO_EDIT;

        //Сохраняем данные
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->refresh();
        }

        return $this->render('edit', compact('model'));
    }

    /**
     *
     * Авторизация пользователя.
     * Если пользователя нет, то создаем нового и отправляем (в данном случае отображаем) данные для входа.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        // Если уже авторизован отправляем домой
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = null;

        //Объявляем модель авторизации
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Если пользователя не существует, то создаем используя модель.
            if(!$model->getUser()) {
                $signup = new SignUp();
                $signup->username = $model->username;
                $user = $signup->signup();
            } else {
                $user = $model->getUser();
            }

            return $this->render('email/authRequest', [
                'user'=>$user
            ]);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     *
     * Авторизация с помощью токена.
     *
     */
    public function actionTokenAuth() {
        $key = Yii::$app->request->getQueryParam('auth_key', null);
        $user = new User();
        $userIdenty = $user->findIdentityByAccessToken($key);

        if(Yii::$app->user->login($userIdenty)){
            $userIdenty->
            $this->goHome();
        }
    }

    /**
     *
     * logout
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
