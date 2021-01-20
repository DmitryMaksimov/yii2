<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

use common\models\User;
use yii\data\Pagination;

/**
 * Site controller
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
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'logout'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = User::find();
//        $query = User::find()->select(['{{user}}.id', '{{user}}.username', 'COUNT({{post}}.id) AS postCount'])->joinWith('author')->groupBy('{{user}}.id');
//        $countQuery = User::find();

//        $pages = new Pagination(['totalCount' => $countQuery->count()]);
//        $users = $query->offset($pages->offset)
//            ->limit($pages->limit)
//            ->all();

        return $this->render('index', [
            'users' => $query,
//            'pages' => $pages,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return redirect
     */
    public function actionDelete($id)
    {
        if($id != 1 && User::findOne($id)->delete()) {
            Yii::$app->authManager->revokeAll($id);
            Yii::$app->session->setFlash('success', 'Пользователь и его посты удалены');
        } else 
            Yii::$app->session->setFlash('failed', 'Ошибка удаления');
        $this->goBack();
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
