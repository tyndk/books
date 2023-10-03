<?php
namespace app\models;

use yii\data\ActiveDataProvider;

class BooksSearch extends Books
{
    public function rules()
    {
        return [
            [['author', 'title', 'year', 'genre', 'pages'], 'safe'],
        ];
    }
    
    public function search($params)
    {
        $query = Books::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'genre', $this->genre])
            ->andFilterWhere(['like', 'pages', $this->pages]);

        return $dataProvider;
    }
}
?>