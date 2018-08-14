<?php

function($date, $type):array {
    $userId = Yii::$app->user->id;
    $dataList = SomeDataModel::find()->where(['date' => $date, 'type' => $type, 'user_id' => $userId])->all();
    $result = [];

	$cacheTime = 3600;

	// получаем данные из кеша
	$cacheKey = $date.$type.$userId;
	$cachedResult = $cache->get($cacheKey);

	// кеша нет, получаем данные
	if(false === $cachedResult) {
	 
	    if (!empty($dataList)) {
	        foreach ($dataList as $dataItem) {
	        	$result[$dataItem->id] = ['a' => $dataItem->a, 'b' => $dataItem->b];
	        }
	    }

	    // если в кеш есть что записать - делаем это
	    if(!empty($result)) {
	    	$cache->set($cacheKey, $result, $cacheTime);
	    }
	} else {
		$result = $cachedResult;
	}
 
    return $result;
}
