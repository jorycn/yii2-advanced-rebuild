<?php

namespace backend\components;

use Yii;
use yii\filters\AccessControl;

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
}