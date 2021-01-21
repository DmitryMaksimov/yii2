<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "redirect".
 *
 * @property int $id
 * @property string $alias
 */
class Redirect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'redirect';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['alias'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Alias',
        ];
    }
}
