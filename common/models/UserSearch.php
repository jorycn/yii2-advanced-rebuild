<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Model search [[User]] records.
 *
 * @property string $username
 * @property string $email
 * @property integer $status
 * @property integer $role_id
 */
class UserSearch extends Model
{


    /**
     * @var string User login
     */
    public $username;

    /**
     * @var string
     */
    public $nickname;

    /**
     * @var string User E-mail
     */
    public $email;

    /**
     * @var string User status
     */
    public $status;

    /**
     * @var string User role
     */
    public $role_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Secure attributes
            [['username', 'email', 'nickname'], 'string'],

            // Role [[role_id]]
            ['role_id', 'in', 'range' => array_keys(User::getRoleArray())],

            // Status [[status]]
            ['status', 'in', 'range' => array_keys(User::getStatusArray())]
        ];
    }

    /**
     * Search records on the specified criteria
     * @param array|null Array of criteria for sampling
     * @return yii\data\ActiveDataProvider dataProvider search results
     */
    public function search($params)
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => (new User)->recordsPerPage
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'nickname', true);
        $this->addCondition($query, 'username', true);
        $this->addCondition($query, 'email', true);
        $this->addCondition($query, 'role_id');
        $this->addCondition($query, 'status');

        return $dataProvider;
    }

    /**
     * Function to add search terms.
     * @param yii\db\Query $query Instance sampling.
     * @param string $attribute Name attribute for which you want to search.
     * @param boolean $partialMatch Added type of comparison. Strict or partial match.
     */
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
