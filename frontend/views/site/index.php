<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */



$this->title = 'Мой суперский БЛОГ';

?>
<div id="dialog" title="Dialog Title">I'm a dialog</div>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <?php
                foreach ($models as $model) {
                    $form = ActiveForm::begin([
                        'id' => 'post-form_{$model->id}',
                    ]);
                    ?>
                    <div class="post__view">
                        <h1> <?php echo $model->title ?> </h1>
                        <?php echo $model->body ?>
                    </div>
                    <div class="post__sub">
                        <?php echo $model->created ?>
                    </div>
                    <?php
                        ActiveForm::end();
                }
            ?>
        </div>
        <?php
            // отображаем ссылки на страницы
            echo yii\widgets\LinkPager::widget([
                'pagination' => $pages,
            ]);
        ?>
    </div>
</div>
