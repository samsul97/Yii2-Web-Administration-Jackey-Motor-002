<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

class Model extends \yii\base\Model
{
    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array $multipleModels
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $serviceModel    = new $modelClass;
        $formName = $serviceModel->formName();
        $post     = Yii::$app->request->post($formName);
        
        // null array
        $models   = [];

        // if not empty array, then validation running used map array static id
        if (!empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        
        // post data service
        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                // set id service
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    // id service not found
                    $models[] = new $modelClass; // nilai service di balikin sampai ketemu id tersebut
                }
            }
        }

        // if success, all data unsetting
        unset($serviceModel, $formName, $post);

        // return array service value
        return $models;
    }
}


