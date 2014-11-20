<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class DbSourceMessage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%source_message}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category' => Yii::t('i18n', 'Category'),
            'message' => Yii::t('i18n', 'Message'),
        ];
    }
}
