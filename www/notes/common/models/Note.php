<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
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
 * @property array $tags
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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required', 'message' => 'Пожалуйста заполните поле.'],
            [['title', 'body'], 'string', 'message' => 'Поле может быть только строкой.'],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('note_tag', ['note_id' => 'id']);
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getTagNames()
    {
        return $this->getTags()->select('name')->column();
    }

    /**
     * @param $tagId
     * @return array|ActiveRecord[]
     */
    public static function findByTagName($tagId)
    {
        return self::find()
            ->joinWith('tags')
            ->where(['tag.id' => $tagId])
            ->all();
    }

}
