<?php
namespace common\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PostSearch extends Model
{

    public $slug;
    public $author_id;
    public $views;
    public $status;
    public $title;
    public $cid;

    public $recordsPerPage = 10;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['slug', 'string'],
            ['title', 'string'],
            ['views', 'integer'],
            ['author_id', 'integer'],
            ['cid', 'integer'],

            ['status', 'in', 'range' => array_keys(Post::getStatusArray())],
        ];
    }

    public function search($params, $static = false)
    {
        $query = Post::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->recordsPerPage
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->leftJoin(PostTranslate::tableName() . ' as tr ', '' .
            Post::tableName() . '.id = tr.post_id'
        );
        $query->andWhere(['like', 'tr.title', $this->title]);

        $this->addCondition($query, 'slug', true);
        $this->addCondition($query, 'views', true);
        $this->addCondition($query, 'status', true);
        $this->addCondition($query, 'author_id');
        $this->addCondition($query, 'cid');

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
