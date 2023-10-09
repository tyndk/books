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
            [['author_id', 'title', 'year', 'genre', 'image', 'pages'], 'required'],
            [['author_id', 'year', 'pages'], 'integer'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
            [['title', 'genre'], 'string', 'max' => 255],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, ico', 'maxSize' => 2056*2056*15]
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

    public function search($params)
    {
        $query = Books::find();

        $query->joinWith('author');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'author_id', $this->author->name]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['year' => $this->year]);
        $query->andFilterWhere(['like', 'genre', $this->genre]);
        $query->andFilterWhere(['pages' => $this->pages]);

        return $dataProvider;
    }

    public function getAuthor()
    {
        return $this->hasOne(Authors::class, ['id' => 'author_id']);
    }
}
