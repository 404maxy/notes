<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $body
 * @property integer $created_at
 * @property integer $updated_at
 * @property bool $is_deleted
 */
class Note extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%note}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['title', 'body'], 'string'],
        ];
    }

    //TODO: связь многие-ко-многим тегами
}
