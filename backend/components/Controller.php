<?php

namespace backend\components;

use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * Main controller for backend app
 */
class Controller extends \yii\web\Controller
{
	/*public function __construct()
	{
		$l = Yii::$app->request->get('l');
		$session = Yii::$app->session;
		if($l){
			$locale = Yii::$app->params['languages'];
			if($locale[$l]){
				Yii::$app->language = $l;
				$session -> set('language', $l);
			}
		}elseif(isset($session['language']) && !$l){
			Yii::$app->language = $session->get('language');
		}
		return true;
	}*/

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['admin']
					]
				]
			]
		];
	}

	/*public function beforeAction($action)
    {
        if(Yii::$app->user->id == 1 || Yii::$app->user->isGuest) return true;
        $action = Yii::$app->controller->id;
        if(Yii::$app->user->can($action)){
            return true;
        }else{
            throw new ForbiddenHttpException('对不起，您现在还没获此操作的权限');
        }
    }*/
}