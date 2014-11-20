<?php

namespace backend\controllers;

use Yii;
use yii\web\HttpException;

use backend\components\Controller;

use common\models\User;
use common\models\UserSearch;

class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all users.
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'roleArray' => User::getRoleArray(),
            'statusArray' => User::getStatusArray()
        ]);
    }

    /**
     * Create new user
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User(['scenario' => 'admin-create']);

        $roleArray = User::getRoleArray();
        $statusArray = User::getStatusArray();
        $auth  = Yii::$app->getAuthManager();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $role = $this->prepareRole(Yii::$app->request->post());
            if($obj = $auth->getRole($role)) {
                $auth->assign($obj, $model->getId());
            }
            Yii::$app->session->setFlash('success', Yii::t('users', 'User \'{username}\' successfully created', ['username' => $model->username]));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'roleArray' => $roleArray,
                'statusArray' => $statusArray
            ]);
        }
    }

    /**
     * Update user
     * @param integer $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('admin-update');
        $roleArray = User::getRoleArray();
        $statusArray = User::getStatusArray();
        $auth  = Yii::$app->getAuthManager();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $role = $this->prepareRole(Yii::$app->request->post());
            $auth->revokeAll($id);
            if($obj = $auth->getRole($role)) {
                $auth->assign($obj, $id);
            }
            Yii::$app->session->setFlash('success', Yii::t('users', 'User \'{username}\' successfully updated', ['username' => $model->username]));
            return $this->redirect(['view', 'id' => $model['id']]);
        } elseif (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        } else {
            $role = $auth->getRolesByUser($id);
            if($role && is_array($role)) {
                $model->role = current($role)->name;
            }
            return $this->render('update', [
                'model' => $model,
                'roleArray' => $roleArray,
                'statusArray' => $statusArray,
            ]);
        }
    }

    /**
     * Show one user
     * @param integer $id
     * @return string
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Delete user.
     * @param integer $id.
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        if($id && $id != 1) {
            $model = $this->findModel($id);
            if($model->delete()) {
                Yii::$app->session->setFlash('success',  Yii::t('users', 'User \'{username}\' successfully removed', ['username' => $model->username]));
            }
        } else {
            Yii::$app->session->setFlash('warning', Yii::t('users', 'User #{id} can not be removed', ['id' => $id]));
        }
        return $this->redirect(['index']);
    }

    /**
     * Model search on the primary key
     * If the model is not found, a 404 error is caused by
     * @param integer|array $id
     * @return user
     * @throws HttpException If the model is not found.
     */
    protected function findModel($id)
    {
        if (is_array($id)) {
            $model = User::find()->where(['id' => $id])->all();
        } else {
            $model = User::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }

    protected function prepareRole($post) {
        return isset($post['User']['role']) ? $post['User']['role'] : '';
    }
}
