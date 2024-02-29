<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $author
 * @property string $title
 */
class Authors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            ['name', 'filter', 'filter' => function($value){
                return strip_tags($value);
            }],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Автор',
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Books::class, ['author_id' => 'id']);
    }
}
