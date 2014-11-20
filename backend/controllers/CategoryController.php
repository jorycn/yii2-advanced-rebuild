<?php

namespace backend\controllers;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\web\HttpException;

use backend\components\Controller;
use backend\models\CategorySearch;

use common\models\Category;
use common\models\CategoryTranslate;


class CategoryController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'atributes' => $this->prepareDetailViewAttributes($id)
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $lang =  $this->prepareLang(Yii::$app->request->post());
            $translate = $this->getTranslateModel($id, $lang);
            if ($translate->load(Yii::$app->request->post()) && $translate->save()) {
                Yii::$app->session->setFlash('success', Yii::t('category', 'Category \'{name}\' successfully updated', ['name' => $model->name]));
            }
            return $this->redirect(['view', 'id' => $id]);
        } else {
            $translates = [];
            foreach(Yii::$app->params['languages'] as $lang => $val) {
                $translates[] = $this->getTranslateModel($id, $lang);
            }
            return $this->render('update', [
                    'model' => $model,
                    'translates' => $translates,
                ]
            );
        }
    }

    public function actionCreate()
    {
        $model = new Category();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $translate = new CategoryTranslate();
            if ($translate->load(Yii::$app->request->post()) && $translate->validate()) {
                $translate->cid = $model->id;
                $translate->save(false);
                Yii::$app->session->setFlash('success', Yii::t('category', 'Category \'{name}\' successfully updated', ['name' => $model->name]));
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $translates = [];
            foreach(Yii::$app->params['languages'] as $lang => $val) {
                $translates[] = $this->getTranslateModel(null, $lang);
            }
            return $this->render('create', [
                    'model' => $model,
                    'translates' => $translates,
                ]
            );
        }
    }

    public function actionDelete($id)
    {
    
        $model = $this->findModel($id);
        if($model->delete()) {
            Yii::$app->session->setFlash('success',  Yii::t('category', 'Category \'{name}\' successfully removed', ['name' => $model->name]));
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (is_array($id)) {
            $model = Category::find()->where(['id' => $id])->all();
        } else {
            $model = Category::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }

    protected function getTranslateModel($id, $lang)
    {
        $translate = CategoryTranslate::find()->where([
            'cid' => $id,
            'language' => $lang,
        ])->one();
        if(!$translate) {
            $translate = new CategoryTranslate();
            $translate->cid = $id;
            $translate->language = $lang;
        }
        return $translate;
    }

    private function prepareDetailViewAttributes($id) {
        $translate = CategoryTranslate::find()->where(['cid' => $id])->all();
        $attributes = [];
        foreach($translate as $val) {
            $attributes[] = [
                'label' => Yii::$app->params['languages'][$val->language],
                'attribute' => 'name',
                'format' => 'raw',
                'value' => $val->title,
            ];
        }
        return $attributes;
    }

    private function prepareLang($post) {
        return isset($post['CategoryTranslate']['language']) ? $post['CategoryTranslate']['language'] : '';
    }
}
