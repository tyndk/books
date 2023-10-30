<?php
namespace app\models;

use yii\data\ActiveDataProvider;

class BooksSearch extends Books
{
    public $author;
    
    public function rules()
    {
        return [
            [['author', 'title', 'year', 'genre', 'pages'], 'safe'],
        ];
    }
    
    public function search($params)
    {
        $query = Books::find();
        $query->joinWith(['author']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['author_id'] = [
            'asc' => ['authors.name' => SORT_ASC],
            'desc' => ['authors.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'authors.name', $this->author])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'genre', $this->genre])
            ->andFilterWhere(['like', 'pages', $this->pages]);

        return $dataProvider;
    }
}
?>