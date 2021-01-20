<?php

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">


        <?php
            $dataProvider = new ActiveDataProvider([
                'query' => $users,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'username',
                    'email',
                    'status',
                    'created_at:datetime',
                    'updated_at:datetime',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'visibleButtons' => [
                            'view' => false,
                            'update' => true,
                            'delete' => true//function ($model, $key, $index) { return $model->id != 1; } 
                        ]
                    ],
                    [
                        'label' => 'Роли',
                        'attribute' => 'id',
                        'format' => 'text',
                        'value' => function($user) {
                            $res = "";
                            foreach ( Yii::$app->authManager->getRolesByUser($user->id) as $role)
                                if($res == "")
                                    $res = $role->name;
                                else
                                    $res += $role->name;
                            return $res;
                        }
                    ],
                ],
            ]);
        ?>

    </div>
</div>
