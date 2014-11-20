<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use yii\web\HttpException;

use backend\models\DbMessage;
use backend\models\DbSourceMessage;
use backend\models\DbMessageSearch;
use backend\components\Controller;

class TranslateController extends Controller
{
    /*
     * This command extracts messages to be translated from source files.
     * The extracted messages are saved as PHP message source files under the specified directory.
     */
    public function updateAllMessage()
    {
        $basePath = Yii::$app->basePath . '/../';
        $cmd = "php {$basePath}yii message {$basePath}common/messages/config.php";
        return shell_exec($cmd);
    }

    public function actionExtract() {
        $this->updateAllMessage();
        Yii::$app->session->setFlash('success', Yii::t('i18n', 'Messages successfully extraction'));
        return $this->redirect(['index']);
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
        $messages = DbMessage::find()->where(['id' => $id])->all();
        if (Model::loadMultiple($messages, Yii::$app->request->post()) && Model::validateMultiple($messages)) {
            foreach ($messages as $message) {
                $message->save(false);
            }
            Yii::$app->session->setFlash('success', Yii::t('i18n', 'Message #{id} successfully updated', ['id' => $id]));
            return $this->redirect(['view', 'id' => $id]);
        } else {
            $model = $this->findModel($id);
            return $this->render('update', [
                    'model' => $model,
                    'messages' => $messages,
                    'atributes' => $this->prepareDetailViewAttributes($id)
                ]
            );
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('i18n', 'Message #{id} successfully removed', ['id' => $id]));
        } else {
            Yii::$app->session->setFlash('warning', Yii::t('i18n', 'Message #{id} can not be removed', ['id' => $id]));
        }
        return $this->redirect(['index']);
    }

    public function actionIndex()
    {
        $searchModel = new DbMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    protected function findModel($id)
    {
        if ($model = DbSourceMessage::findOne($id)) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }

    private function prepareDetailViewAttributes($id) {
        $translate = DbMessage::find()->where(['id' => $id])->all();
        $attributes = [];
        foreach($translate as $val) {
            $attributes[] = [
                'label' => Yii::$app->params['languages'][$val->language],
                'attribute' => 'message',
                'format' => 'raw',
                'value' => $val->translation,
            ];
        }
        return $attributes;
    }
}
