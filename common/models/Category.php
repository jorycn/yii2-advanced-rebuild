<?php
namespace common\models;

use yii;
use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'unique'],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/'],
            ['name', 'string', 'min' => 3, 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('category', 'Name'),
        ];
    }

    public function getTitle() {
        if($this->id) {
            $model = CategoryTranslate::find()->where([
                'cid' => $this->id,
                'language' => Yii::$app->language
            ])->one();
        }
        return ($model !== null) ? $model->title : '';
    }

    public static function getCategorysForSelect() {
        $cate = [];
        $sql = "SELECT s.id, st.title
                FROM " . Category::tableName() . " as s
                LEFT JOIN " . CategoryTranslate::tableName() . " as st
                   ON s.id = st.cid
                WHERE st.language = :lang";
        $models = CategoryTranslate::findBySql($sql, [
            ':lang' => Yii::$app->language
        ])->all();
        foreach($models as $model) {
            $cate[$model->id] = $model->title;
        }
        return $cate;
    }
}
