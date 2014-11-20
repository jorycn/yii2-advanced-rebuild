<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\Category;
use common\models\CategoryTranslate;

class CategorySearch extends Model
{
    public $name;
    public $title;

    public $recordsPerPage = 10;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Category::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->recordsPerPage,
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->leftJoin(RubricTranslate::tableName() . ' as tr ', '' .
            Category::tableName() . '.id = tr.cid AND tr.language = \'' . Yii::$app->language . '\''
        );
        $query->andWhere(['like', 'tr.title', $this->title]);
        $query->andWhere(['like', Category::tableName() . '.name', $this->name]);

        return $dataProvider;
    }
}
