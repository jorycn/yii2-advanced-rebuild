<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DbMessageSearch extends Model
{
    public $category;
    public $message;

    public $recordsPerPage = 50;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'message'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = DbSourceMessage::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->recordsPerPage,
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $this->addCondition($query, 'category', true);
        $this->addCondition($query, 'message', true);

        return $dataProvider;
    }

    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
