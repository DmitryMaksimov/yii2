<?php

namespace common\models;

use Yii;

class PostAjax extends \yii\base\Model
{
    public $id;
    public $body;
    public $title;
    public function rules()
    {
        return [
            [['body', 'id', 'title'], 'required'],
            [['id'], 'integer'],
            [['body', 'title'], 'string'],
        ];
    }
}
?>