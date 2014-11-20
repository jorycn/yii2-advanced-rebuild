<?php
namespace common\models;

use yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

class CategoryTranslate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category_translate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'min' => 3, 'max' => 64],

            ['language', 'required'],
            ['language', 'in', 'range' => array_keys(Yii::$app->params['languages'])],

            ['cid', 'integer'],

            ['meta_title', 'string'],
            ['meta_keywords', 'string'],
            ['meta_descriptions', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => Yii::t('category', 'Category'),
            'language' => Yii::t('category', 'Language'),
            'title' => Yii::t('category', 'Title'),
            'meta_title' => Yii::t('category', 'Meta title'),
            'meta_keywords' => Yii::t('category', 'Meta keywords'),
            'meta_descriptions' => Yii::t('category', 'Meta descriptions'),
        ];
    }

}
