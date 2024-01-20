<?php

namespace backend\controllers;

use backend\models\MrDivision;
use backend\models\MrLocation;

class ReffController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLocation($type, $name)
    {
	    $province = "<option value=''>-</option>";
	    $city     = "<option value=''>-</option>";
	    $district = "<option value=''>-</option>";

    	if ($type === 'P')
    	{
	    	$model = MrLocation::find()->where(['province_name' => $name])->groupBy(['city_name'])->asArray()->all();
	    	
	    	foreach ($model as $key => $value) 
	    	{
	    		$city.= '<option value="' . $value['city_name'] . '">' . $value['city_name'] . '</option>';
	    	}
    	}
    	else if ($type === 'C')
    	{
	    	$model = MrLocation::find()->where(['city_name' => $name])->groupBy(['district_name'])->asArray()->all();
	    	
	    	foreach ($model as $key => $value) 
	    	{
	    		$district.= '<option value="' . $value['district_name'] . '">' . $value['district_name'] . '</option>';
	    	}

    	}
    	else if ($type === 'D')
    	{

    	}

    	return json_encode(array(
    			'province' => $province,
    			'city' => $city,
    			'district' => $district,
    		)
    	);
    }

	// division employee
    public function actionDivision($type, $name)
    {
        $department = "<option value=''>-</option>";
        $position = "<option value=''>-</option>";

        if ($type === 'D') {
            $model = MrDivision::find()->where(['department_name' => $name])->groupBy(['position_name'])->asArray()->all();
	    	
	    	foreach ($model as $key => $value) 
	    	{
	    		$position.= '<option value="' . $value['position_name'] . '">' . $value['position_name'] . '</option>';
	    	}
        }
        elseif ($type === 'P') {
            
        }
        return json_encode(array(
            'department' => $department,
            'position' => $position,
        )
    );
    }

	// Division Surat Mutasi
	public function actionDivisionmutasi($type, $name)
    {
        $department = "<option value=''>-</option>";
        $position = "<option value=''>-</option>";

        if ($type === 'D') {
            $model = MrDivision::find()->where(['department_name' => $name])->groupBy(['position_name'])->asArray()->all();
	    	
	    	foreach ($model as $key => $value) 
	    	{
	    		$position.= '<option value="' . $value['position_name'] . '">' . $value['position_name'] . '</option>';
	    	}
        }
        elseif ($type === 'P') {
            
        }
        return json_encode(array(
            'department' => $department,
            'sm_new_position' => $position,
        )
    );
    }

}
