<?php

namespace backend\controllers;

use Yii;
use yii\web\HttpException;

use backend\models\Auth;
use backend\models\AuthSearch;
use backend\components\Controller;

class RolesController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new AuthSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get(), Auth::TYPE_ROLE);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new Auth();
        if ($model->load(Yii::$app->request->post())) {
            $permissions = $this->preparePermissions(Yii::$app->request->post());
            if($model->createRole($permissions)) {
                Yii::$app->session->setFlash('success', 'Role' . " '$model->name' " . 'successfully saved');
                return $this->redirect(['view', 'name' => $model->name]);
            }
        } else {
            $permissions = $this->getPermissions();
            return $this->render('create', [
                    'model' => $model,
                    'permissions' => $permissions
                ]
            );
        }
    }

    public function actionUpdate($name)
    {
        if($name == 'admin') {
            Yii::$app->session->setFlash('success', 'The Administrator has all permissions');
            return $this->redirect(['view', 'name' => $name]);
        }
        $model = $this->findModel($name);
        if ($model->load(Yii::$app->request->post())) {
            $permissions = $this->preparePermissions(Yii::$app->request->post());
            if($model->updateRole($name, $permissions)) {
                Yii::$app->session->setFlash('success', 'Role' . " '$model->name' " . 'successfully updated');
                return $this->redirect(['view', 'name' => $name]);
            }
        } else {
            $permissions = $this->getPermissions();
            $model->loadRolePermissions($name);
            return $this->render('update', [
                    'model' => $model,
                    'permissions' => $permissions,
                ]
            );
        }
    }

    public function actionDelete($name)
    {
        if ($name) {
            if(!Auth::hasUsersByRole($name)) {
                $auth = Yii::$app->getAuthManager();
                $role = $auth->getRole($name);

                // clear asset permissions
                $permissions = $auth->getPermissionsByRole($name);
                foreach($permissions as $permission) {
                    $auth->removeChild($role, $permission);
                }
                if($auth->remove($role)) {
                    Yii::$app->session->setFlash('success', 'Role' . " '$name' " . 'successfully removed');
                }
            } else {
                Yii::$app->session->setFlash('warning', 'Role' . " '$name' " . 'still used');
            }
        }
        return $this->redirect(['index']);
    }

    public function actionView($name)
    {
        $model = $this->findModel($name);
        $model->loadRolePermissions($name);
        $permissions = $this->getPermissions();
        return $this->render('view', [
            'model' => $model,
            'permissions' => $permissions,
        ]);
    }

    protected function findModel($name)
    {
        if ($name) {
            $auth = Yii::$app->getAuthManager();
            $model = new Auth();
            $role = $auth->getRole($name);
            if ($role) {
                $model->name = $role->name;
                $model->description = $role->description;
                $model->setIsNewRecord(false);
                return $model;
            }
        }
        throw new HttpException(404);
    }

    protected function getPermissions() {
        $models = Auth::find()->where(['type' => Auth::TYPE_PERMISSION])->all();
        $permissions = [];
        foreach($models as $model) {
            $permissions[$model->name] = $model->name . ' (' . $model->description . ')';
        }
        return $permissions;
    }

    protected function preparePermissions($post) {
        return (isset($post['Auth']['_permissions']) &&
            is_array($post['Auth']['_permissions'])) ? $post['Auth']['_permissions'] : [];
    }
}
