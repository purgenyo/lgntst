<?php

namespace app\components;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class MainController extends Controller
{
    /**
     *
     * Управление доступом пользователя.
     * Фильтрация http запросов
     *
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error', 'login', 'token-auth'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
        ];

        return $behaviors;
    }
}