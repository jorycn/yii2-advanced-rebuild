<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class DbMessage extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['translation', 'required'],
            ['translation', 'string', 'min' => 1, 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'language' => Yii::t('i18n', 'Language'),
            'translation' => Yii::t('i18n', 'Translation'),
        ];
    }

}
