<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\UserForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'User properties';
?>
<div class="site-user">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

            <?php $form = ActiveForm::begin([
                'id' => 'user-form',
                'action' => yii\helpers\Url::to(["site/update", 'id' => $model->id]),
            ]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email')->textInput() ?>

                <?= $form->field($model, 'password')->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-block', 'name' => 'save-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
</div>