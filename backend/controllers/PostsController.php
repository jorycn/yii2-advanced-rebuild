<?php

namespace backend\controllers;

use Yii;
use yii\web\HttpException;

use backend\components\Controller;

use common\models\User;
use common\models\Post;
use common\models\PostSearch;
use common\models\PostTranslate;
use common\models\Category;

use common\extensions\fileapi\actions\UploadAction;
use common\extensions\fileapi\actions\DeleteAction;

class PostsController extends Controller
{
    public function actions()
    {
        $post = new Post();
        return [
            'uploadTempPreview' => [
                'class' => UploadAction::className(),
                'path' => Post::previewTempPath(),
                'types' => $post->previewAllowedExtensions,
                'minHeight' => $post->previewHeight,
                'minWidth' => $post->previewWidth
            ],
            'deleteTempPreview' => [
                'class' => DeleteAction::className(),
                'path' => Post::previewTempPath()
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $postStatuses = Post::getStatusArray();
        $users = User::getUsersForSelect();
        $categories = Category::getCategorysForSelect();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'postStatuses' => $postStatuses,
            'categories' =>$categories,
            'users' => $users,
        ]);
    }

    public function actionCreate()
    {
        if(!Category::find()->count()) {
            Yii::$app->session->setFlash('warning',  Yii::t('category', 'You should add category first !'));
            return $this->redirect(['/category']);
        }
        $model = new Post(['scenario' => 'admin-edit-page-static']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $translate = new PostTranslate();
            $translate->post_id = $model->id;
            if ($translate->load(Yii::$app->request->post()) && $translate->save()) {
                Yii::$app->session->setFlash('success', Yii::t('posts', 'Post \'{id}\' successfully created', ['id' => $model->id]));
            }
            return $this->redirect(['index']);
        } else {
            $model->published_date = date('Y-m-d');
            $translates = [];
            foreach(Yii::$app->params['languages'] as $lang => $val) {
                $translates[] = $this->getTranslateModel(null, $lang);
            }
            $postStatuses = Post::getStatusArray();
            return $this->render('create', [
                'model' => $model,
                'translates' => $translates,
                'postStatuses' => $postStatuses,
                'category' => Category::getCategorysForSelect()
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('admin-edit-page-static');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $lang = $this->prepareLang(Yii::$app->request->post());
            $translate = $this->getTranslateModel($model->id, $lang);
            if ($translate->load(Yii::$app->request->post()) && $translate->save()) {
                Yii::$app->session->setFlash('success', Yii::t('posts', 'Post \'{id}\' successfully updated', ['id' => $model->id]));
            }
            return $this->redirect(['index']);
        } else {
            $translates = [];
            foreach(Yii::$app->params['languages'] as $lang => $val) {
                $translates[] = $this->getTranslateModel($id, $lang);
            }
            $postStatuses = Post::getStatusArray();
            $category = Category::getCategorysForSelect();
            return $this->render('create', [
                'model' => $model,
                'translates' => $translates,
                'postStatuses' => $postStatuses,
                'category' => $category
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete()) {
            foreach(Yii::$app->params['languages'] as $lang => $val) {
                $translate = PostTranslate::find()->where([
                    'post_id' => $id,
                    'language' => $lang,
                ])->one();
                if($translate) {
                    $translate->delete();
                }
            }
            Yii::$app->session->setFlash('success',  Yii::t('posts', 'Posts #{id} successfully removed', ['id' => $model->id]));
        }
        return $this->redirect(['index']);
    }

    protected function getTranslateModel($id, $lang)
    {
        $translate = PostTranslate::find()->where([
            'post_id' => $id,
            'language' => $lang,
        ])->one();
        if(!$translate) {
            $translate = new PostTranslate();
            $translate->post_id = $id;
            $translate->language = $lang;
        }
        return $translate;
    }

    protected function findModel($id)
    {
        if (is_array($id)) {
            $model = Post::find()->where(['id' => $id])->all();
        } else {
            $model = Post::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }

    private function prepareLang($post) {
        return isset($post['PostTranslate']['language']) ? $post['PostTranslate']['language'] : '';
    }

    function actionDeleteImage()
    {
        if ($id = Yii::$app->request->getBodyParam('id')) {
            $model = $this->findModel($id);
            $model->save(false);
        } else {
            throw new HttpException(400);
        }
    }

    function actionDeletePreview()
    {
        if ($id = Yii::$app->request->getBodyParam('id')) {
            $model = $this->findModel($id);
            $model->save(false);
        } else {
            throw new HttpException(400);
        }
    }

    function actionGetRubric() {
        $data = Yii::$app->request->post();
        if(isset($data['id'])) {
            $section_id = $data['id'];
            $category = Rubric::getCategoryForSelect($section_id);
            print json_encode($category);
        }
        exit;
    }

}
