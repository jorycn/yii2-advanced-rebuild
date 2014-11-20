<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\Section;
use common\models\SectionTranslate;

class SectionSearch extends Model
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
        $query = Section::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->recordsPerPage,
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->leftJoin(SectionTranslate::tableName() . ' as tr ', '' .
            Section::tableName() . '.id = tr.section_id AND tr.language = \'' . Yii::$app->language . '\''
        );
        $query->andWhere(['like', 'tr.title', $this->title]);
        $query->andWhere(['like', Section::tableName() . '.name', $this->name]);

        return $dataProvider;
    }
}
