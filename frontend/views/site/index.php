<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\jui\Dialog;

/* @var $this yii\web\View */



$this->title = 'Мой суперский БЛОГ';

Dialog::begin([
    'id' => "EditDialog",
    'clientOptions' => [
        'autoOpen' => false,
        'modal' => true,
        'width' => "90%",
        'maxWidth' => "768px",
    ],
]);

    echo Html::textarea("", $model->body,  [
        'id' => "TextEditor",
        'rows' => '10',
        'style' => '
            width: 100%;
            height: auto;
        ',
    ]);
    echo Html::button("Предпросмотр", [
        'id' => 'Preview',
        'onclick' => "
            $(EditDialog).dialog('close');
            EditDialog.form_to_edit.find('#postajax-body').prop('value', TextEditor.value);
            EditDialog.form_to_edit.find('#post_body').html(TextEditor.value);
            EditDialog.form_to_edit.find('#SaveButton').prop('disabled', false);
        "]
    );

Dialog::end();

$this->registerJs( "
    $('#post-form').each(function() {
        var form = $(this);
        form.on('beforeSubmit', function() {
            var data = $(this).serialize();
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: data,
                success: function (data) {
                    if(data.error == null) {
                        console.log(form);
                        form.find('#SaveButton').prop('disabled', true);
                    }
                },
                error: function(jqXHR, errMsg) {
                    alert('error: ' + errMsg);
                }
                });
                return false; // prevent default submit
            });
    });",
    yii\web\View::POS_READY,
    'post-form-beforesubmit'
);

$this->registerJs( "
    $('#EditBody').each(function() {
        $(this).on('click', function() {
            EditDialog.form_to_edit = $(this).parents('form');
            TextEditor.value = EditDialog.form_to_edit.find('#postajax-body').prop('value');
            $(EditDialog).dialog('open');
        });
    });
    ",
    yii\web\View::POS_READY,
    'edit-body-onclick'
);


?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <?php
            foreach ($models as $model) {

                $form = ActiveForm::begin([
                    'id' => "post-form",
                    'action' => ['site/update-post']
                ]);

                $ajax->id = $model->id;
                $ajax->body = $model->body;
                $ajax->title = $model->title;

                echo $form->field($ajax, 'id')->hiddenInput()->label(false);
                echo $form->field($ajax, 'title')->hiddenInput()->label(false);
                echo $form->field($ajax, 'body')->hiddenInput()->label(false);

                ?>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="post__view">
                        <h1> <?php echo $model->title ?> </h1>
                        <div id="post_body">
                            <?php echo $model->body ?>
                        </div>
                    </div>
                    <div class="post__sub">
                        
                        <?php
                        if( Yii::$app->User->isGuest ) {
                            echo Html::button("Редактировать", [ 'id' => 'EditBody' ]);
                            echo Html::submitInput("Сохранить", [
                                'id' => "SaveButton",
                                "disabled" => true,
                            ]);
                        }

                        echo $model->created
                        ?>

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
