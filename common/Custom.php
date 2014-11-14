<?php namespace common;

use Yii;
use yii\helpers\Url;

class Custom
{

	public static function getBaseUrl($url = null)
	{
		$baseUrl = \Yii::$app->request->getBaseUrl();
		if($url !== null)
		{
			$baseUrl .= $url;
		}
		return $baseUrl;
	}
	
}

