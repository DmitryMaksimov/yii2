<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use frontend\models\Redirect;

class NamesController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['get', 'index', 'create'],
                        'allow' => true,
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    public function actionGet($id)
    {
        $model = Redirect::findOne($id);

        if($model) {
            Yii::trace($model->alias);
            return Yii::$app->response->redirect( $model->alias, 302);
        }
        return $this->goHome();
    }

    public function actionCreate()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new Redirect;
        
        if ( ! Yii::$app->request->isAjax ) {

            Yii::$app->response->setStatusCode(403);
            return 'Not AJAX request';

        }

        if($model->load(Yii::$app->request->post())) {
            $old = Redirect::find()->where(['alias' => $model->alias])->one();
            if($old != null)
                return [ 'url' => Yii::$app->request->getHostInfo() . '/' . strval($old->id) ];
            else {
                if($model->save())
                    return [ 'url' => Yii::$app->request->getHostInfo() . '/' . strval($model->id) ];
            }
        }
        Yii::$app->response->setStatusCode(500);
        return 'Failed to load or save data!';
    }

    public function actionIndex()
    {
        $model = new Redirect;

        return $this->render('index', [ 'model' => $model ]);
    }

}
