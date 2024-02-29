<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property int $year
 * @property string $genre
 * @property string $image
 * @property int $pages
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'title', 'genre'], 'required'],
            [['author_id', 'year', 'pages'], 'integer', 'min' => 1],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
            [['title', 'genre'], 'string', 'max' => 255],
            ['title', 'filter', 'filter' => function($value){
                return strip_tags($value);
            }],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, ico', 'maxSize' => 1024*1280*15],
            ['title', 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'title' => 'Название',
            'year' => 'Год',
            'genre' => 'Жанр',
            'image' => 'Картинка',
            'pages' => 'Страницы',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Authors::class, ['id' => 'author_id']);
    }
}
