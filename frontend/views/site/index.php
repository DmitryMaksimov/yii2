<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\jui\Dialog;

/* @var $this yii\web\View */



$this->title = 'Мой суперский БЛОГ';

?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <?php
            foreach ($models as $model) {

                $editable = $model->author_id == Yii::$app->User->id || Yii::$app->User->identity->role;

                echo Html::beginTag('div', [
                    'class' => 'post__view',
                    'data' => [
                        'action' => yii\helpers\Url::to(["site/update-post", 'id' => $model->id]),
                    ],
                ]);
                    echo Html::beginTag('h1');
                        echo Html::tag('div', $model->title, [
                            'class' => 'post__title',
                            'contenteditable' => $editable,
                            'oninput' => '$(this).parents(".post__view").find("#SavePost").prop("disabled", false)',
                            'onclick' => '$(this).parents(".post__view").find(".post__edited").show("slow")'
                        ]);
                    echo Html::endTag('h1');
                    echo Html::tag('div', $model->body, [
                        'class' => 'post__body',
                        'contenteditable' => $editable,
                        'oninput' => '$(this).parents(".post__view").find("#SavePost").prop("disabled", false)',
                        'onclick' => '$(this).parents(".post__view").find(".post__edited").show("slow")'
                    ]);

                    echo Html::beginTag('div', [ 'class' => 'post__sub']);

                        if( $editable ) {
                            echo Html::beginTag('div', [ 'class' => 'post__edited' ]);
                                echo Html::button("Сохранить", [ 'class' => "post__save" ]);
                                echo Html::a('Удалить', ['site/delete-post', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Вы действительно хотите удалить пост?',
                                        'method' => 'post',
                                    ],
                                ]);
                            echo Html::endTag('div');
                        }
                        echo Html::tag('p', ($model->updated)?$model->updated:$model->created, [ 'class' => 'post__updated' ]);
                        echo Html::tag('p', $model->author->username, [ 'class' => 'post__author' ]);

                    echo Html::endTag('div');
                echo Html::endTag('div');
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
<?php

$this->registerJs( "$('.post__edited').hide();",
    yii\web\View::POS_READY,
    'post-form-prepare'
);

if( !Yii::$app->User->isGuest && $models ) {

    $form = ActiveForm::begin([
        'id' => "post-form",
        'action' => ["site/update-post"]
    ]);
        echo $form->field($model, 'title')->hiddenInput()->label(false);
        echo $form->field($model, 'body')->hiddenInput()->label(false);
    ActiveForm::end();

/*
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
            ]
        );

    Dialog::end();
*/
    $this->registerJs( "
        $('#post-form').on('beforeSubmit', function() {
            var data = $(this).serialize();
            var post__edited = $(this).data('post__edited');
            var post_to_save = $(this).data('post_to_save');
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: data,
                success: function (data) {
                    post__edited.hide('fast');
                    if(data.error == null)
                        post_to_save.find('.post__updated').html(data.updated);
                    else
                        alert(data.error);
                },
                error: function(jqXHR, errMsg) {
                    alert('error: ' + jqXHR.status);
                }
            });
            return false; // prevent default submit
        });",
        yii\web\View::POS_READY,
        'post-form-beforesubmit'
    );
/*
    $this->registerJs( "
        $('#Preview').on('click', function() {
            $(EditDialog).dialog('close');
            EditDialog.post_to_edit.find('.post__body')
                .html(TextEditor.value)
                .data('body', TextEditor.value);
            EditDialog.post_to_edit.find('#SavePost').prop('disabled', false);
        });",
        yii\web\View::POS_READY,
        'preview-body-onclick'
    );
*/
    $this->registerJs( "
        $('.post__save').on('click', function() {
            var post_to_save = $(this).parents('.post__view');

            $('#post-title').prop('value', post_to_save.find('.post__title').html());
            $('#post-body').prop('value', post_to_save.find('.post__body').html());

            $('#post-form')
                .data('post__edited', post_to_save.find('.post__edited'))
                .data('post_to_save', post_to_save)
                .prop('action', post_to_save.data('action'))
                .submit();
        });",
        yii\web\View::POS_READY,
        'savepost-body-onclick'
    );

}

?>