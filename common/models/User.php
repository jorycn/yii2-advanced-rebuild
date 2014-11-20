<?php
namespace common\models;

use yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * User status
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = 2;
    const STATUS_DELETED = 3;

    /**
     * @var string Readable user status
     */
    protected $_status;

    /**
     * @var int def user role
     */
    public $role;

    /**
     * Chance of used for collecting user information, but are not stored in the database
     * @var string $password
     */
    public $password;

    /**
     * Chance of used for collecting user information, but are not stored in the database
     * @var string $repassword
     */
    public $repassword;

    /**
     * @var integer Number of records on the users page
     */
    public $recordsPerPage = 20;

    /**
     * @var boolean
     */
    public $rememberMe = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Login [[username]]
            ['username', 'filter', 'filter' => 'trim', 'on' => ['signup', 'admin-update', 'admin-create']],
            ['username', 'required', 'on' => ['signup', 'admin-update', 'admin-create']],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'on' => ['signup', 'admin-update', 'admin-create']],
            ['username', 'string', 'min' => 3, 'max' => 30, 'on' => ['signup', 'admin-update', 'admin-create']],
            ['username', 'unique', 'on' => ['signup', 'admin-update', 'admin-create']],

            // Name and Surname  [[name]] & [[nickname]]
            [['nickname'], 'required', 'on' => ['admin-update', 'admin-create']],
            [['nickname'], 'string', 'max' => 50, 'on' => ['admin-update', 'admin-create']],
            ['nickname', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'on' => ['admin-update', 'admin-create']],

            // User role [[role_id]]
/*            ['role_id', 'default', 'value' => self::ROLE_USER, 'on' => ['admin-update', 'admin-create']],*/
            ['role', 'in', 'range' => array_keys(self::getRoleArray()), 'on' => ['admin-update', 'admin-create']],

            // User status [[status]]
            ['status', 'default', 'value' => self::STATUS_ACTIVE, 'on' => ['admin-update', 'admin-create']],
            ['status', 'in', 'range' => array_keys(self::getStatusArray()), 'on' => ['admin-update', 'admin-create']],

            // E-mail [[email]]
            ['email', 'filter', 'filter' => 'trim', 'on' => ['signup','admin-update', 'admin-create']],
            ['email', 'string', 'max' => 100, 'on' => ['signup', 'admin-update', 'admin-create']],
            ['email', 'required', 'on' => ['signup', 'admin-update', 'admin-create']],
            ['email', 'email', 'on' => ['signup', 'admin-update', 'admin-create']],
            ['email', 'unique', 'on' => ['signup', 'admin-update', 'admin-create'], 'message' => 'Email already exists'],

            // Password [[password]]
            ['password', 'required', 'on' => ['signup', 'admin-create']],
            ['password', 'string', 'min' => 6, 'max' => 30, 'on' => ['signup', 'admin-update', 'admin-create']],

            // Confirm password [[repassword]]
            ['repassword', 'required', 'on' => ['signup', 'admin-create']],
            ['repassword', 'string', 'min' => 6, 'max' => 30, 'on' => ['signup', 'admin-update', 'admin-create']],
            ['repassword', 'compare', 'compareAttribute' => 'password', 'on' => ['signup', 'admin-create']],
            ['repassword', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'on' => ['signup', 'admin-update']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nickname' => Yii::t('users', 'Nickname'),
            'username' => Yii::t('users', 'Username'),
            'role' => Yii::t('users', 'Role'),
            'status' => Yii::t('users', 'Status'),
            'email' => Yii::t('users', 'E-Mail'),
            'password' => Yii::t('users', 'Password'),
            'repassword' => Yii::t('users', 'Confirm password'),
            'repassword' => Yii::t('users', 'Confirm password'),
            'created_at' => Yii::t('users', 'Created'),
            'updated_at' => Yii::t('users', 'Updated'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            // Backend scenarios
            'admin-create' => ['nickname', 'username', 'email', 'password', 'status', 'role_id'],
            'admin-update' => ['nickname', 'username', 'email', 'password', 'status', 'role_id'],

            // Frontend scenarios
            'signup' => ['username', 'email', 'password', 'repassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                if (!empty($this->password)) {
                    $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                }

                if (!$this->status) {
                    $this->status = self::STATUS_ACTIVE;
                }
                $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
            }
            else {
                if ($this->scenario === 'admin-update') {
                    if (!empty($this->password)) {
                        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomKey() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return array Array of available user roles.
     */
    public static function getRoleArray()
    {
        $auth  = Yii::$app->getAuthManager();
        $models = $auth->getRoles();
        $roles = [];
        foreach($models as $model) {
            $roles[$model->name] = $model->name;
        }
        return $roles;
    }

    /**
     * @return array Array of available user status.
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_DELETED => Yii::t('users', 'Deleted'),
            self::STATUS_ACTIVE => Yii::t('users', 'Active'),
            self::STATUS_INACTIVE => Yii::t('users', 'Inactive'),
            self::STATUS_BANNED => Yii::t('users', 'Banned')
        ];
    }

    /**
     * @return string Readable user status
     */
    public function getStatus()
    {
        if ($this->_status === null) {
            $statuses = self::getStatusArray();
            $this->_status = $statuses[$this->status];
        }
        return $this->_status;
    }

    public static function getUsersForSelect() {
       $models = User::find()->select(['id', 'username'])->all();
       foreach($models as $model) {
           $users[$model->id] = $model->username;
       }
       return $users;
    }
}
