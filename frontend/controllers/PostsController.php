<?php

namespace frontend\controllers;

use Yii;
use yii\web\HttpException;

use yii\web\Controller;
use yii\helpers\Url;

use common\models\User;
use common\models\Post;
use common\models\PostSearch;
use common\models\PostTranslate;
use common\models\Category;

class PostsController extends Controller
{
    
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $categories = Category::getCategorysForSelect();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'categories' =>$categories,
        ]);
    }


    public function actionView()
    {
        if($post = Post::getPostBySlug(Url::to('@web'))) {
            return $this->render('view', [
                'model' => $post,
            ]);
        } else {
            throw new HttpException(404);
        }
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



}
