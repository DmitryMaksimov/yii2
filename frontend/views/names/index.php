<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJs( "
    $(result_block).hide();
    $('#post-form').on('beforeSubmit', function() {
        var data = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: data,
            success: function (data) {
                if(data.url != null) {
                    $(result_url).prop('value', data.url);
                    $(result_block).show('normal');
                } else
                    alert('Ошибка');
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

?>
<h1>Генератор простых Url</h1>

<p>
    <?php
    
    Yii::trace(['model' => $model]);

    $form = ActiveForm::begin([
        'id' => "post-form",
        'action' => ["names/create"],
    ]);
        echo $form->field($model, 'alias')->textInput();
        ?>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-block', 'name' => 'save-button']) ?>
        </div>
        <?php
    ActiveForm::end();
    
    ?>
        <div id='result_block' class='has-success'>
            <label for='result_url' class='control-label'>Result url</label>
            <input id='result_url' type='text' class='form-control' />
        </div>
</p>
