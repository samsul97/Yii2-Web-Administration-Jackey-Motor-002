<?php

namespace backend\controllers;

use Yii;
use backend\models\TbEstimation;
use backend\models\TbCustomer;
use backend\models\TbEstimationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Model;
use backend\models\TbEstimationService;
use backend\models\TbWorkOrder;
use backend\models\TbWorkOrderService;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * TbEstimationController implements the CRUD actions for TbEstimation model.
 */
class TbEstimationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'ruleConfig' => [
                'class' => \common\components\AccessRule::className()],
                'rules' => \common\components\AccessRule::getRules(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        /* Application Log */
        Yii::$app->application->log($action->id);
        if (!parent::beforeAction($action)) {
            return false;
        }
        // Another code here
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        // Code here
        return $result;
    }

    /**
     * Lists all TbEstimation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TbEstimationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbEstimation model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbEstimation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // estimasi model initial Load
        $model = new TbEstimation;

        // service model initial Load
        $serviceModel = [new TbEstimationService];

        // customer Model Initial Load
        $customerModel = new TbCustomer();

        // customer ID From AJAX POST
        $customerId = Yii::$app->request->post('customer');

        if ($model->load(Yii::$app->request->post())) {
            
            $model->no_estimation = $model->generateEstimationNumber($customerId);
            $model->id_customer = $customerId;
            $model->save();

            // service validation
            $serviceModel = Model::createMultiple(TbEstimationService::classname());
            Model::loadMultiple($serviceModel, Yii::$app->request->post());

            // ajax validation case if used ajax
            if (Yii::$app->request->isAjax) {

                // json format converting
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($serviceModel),
                    ActiveForm::validate($model)
                );
            }

            // multiple validation
            $valid = $model->validate();
            $valid = Model::validateMultiple($serviceModel) && $valid;

            // multiple store with validation
            if ($valid) {
                // yii function for transaction process
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        foreach ($serviceModel as $item) {

                            $item->id_tb_estimation = $model->id;

                            if ($item->qty !== null && is_numeric($item->qty) && $item->price !== null && is_numeric($item->price)) {
                                $item->amount = intval($item->qty) * $item->price;
                            }

                            // failed store
                            if (!($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    // success store
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index', 'id' => $model->id]);
                    }
                    
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        else {
            return $this->render('create', [
                'model' => $model,
                'customer' => $customerId,
                'customerModel' => $customerModel,
                'serviceModel' => (empty($serviceModel)) ? [new TbEstimationService] : $serviceModel
            ]);
        }
    }

    /**
     * Updates an existing TbEstimation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // customer ID From AJAX POST
        $customerId = Yii::$app->request->post('customer');
        
        $serviceModel = $model->serviceItems;

        if ($model->load(Yii::$app->request->post())) {
            
            $model->no_estimation = $model->generateEstimationNumber($customerId);
            $model->id_customer = $customerId;
            $model->save();

            $oldIDs = ArrayHelper::map($serviceModel, 'id', 'id');
            $serviceModel = Model::createMultiple(TbEstimationService::classname(), $serviceModel);
            Model::loadMultiple($serviceModel, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($serviceModel, 'id', 'id')));
            
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($serviceModel),
                    ActiveForm::validate($model)
                );
            }
            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($serviceModel) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($serviceModel as $item) {

                            $item->id_tb_estimation = $model->id;
                            
                            if ($item->qty !== null && is_numeric($item->qty) && $item->price !== null && is_numeric($item->price)) {
                                $item->amount = $item->qty * $item->price;
                            }

                            if (!empty($deletedIDs)) {
                                TbEstimationService::deleteAll(['id' => $deletedIDs]);
                            }

                            if (!($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        else 
        {
            return $this->render('update', [
                'model' => $model,
                'serviceModel' => (empty($serviceModel)) ? [new TbEstimationService] : $serviceModel,
            ]);
        }
    }

    /**
     * Deletes an existing TbEstimation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbEstimation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbEstimation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TbEstimation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrintEstimation($id)
    {
        $model = TbEstimation::findOne($id);

        // services array
        $allServices = TbEstimationService::find()
                    ->where(['id_tb_estimation' => $model->id])
                    ->orderBy(['qty' => SORT_DESC])
                    ->all();

        // total price
        $sum = TbEstimationService::find()
                ->where(['id_tb_estimation' => $model->id])
                ->sum('amount');
        
        $content = $this->renderPartial('/tb-estimation/print/estimation', [
                    'model' => $model,
                    'allServices' => $allServices,
                    'sum' => $sum,
                ]);

        $cssInline = <<< CSS
            .table1 {
                font-family: sans-serif;
                /* font-weight:normal; */
                color: #232323;
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #000000;
            }
            .table1, th, td {
                border: 1px solid #000000;
                padding: 3px 2px;
            }
            .table1 tr:hover {
                background-color: #f5f5f5;
            }
        CSS;

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'marginLeft' => 6,
            'marginRight' => 5,
            'marginTop' => 4,
            'format' => [210,297],
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssInline' => $cssInline,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => ['title' => 'Estimasi Order'],
            'methods' => [
                'SetHeader'=> [null],
                'SetFooter'=> [null],
            ]
        ]);
        $date = date('d-m-Y His');
        $pdf->filename = "Estimasi - ". $date . '-' . $model->customer->name .".pdf";
        return $pdf->render();
    }

    public function actionCustomerData($id)
    {
        $customerData = TbCustomer::findOne(['id' => $id]);
        
        return json_encode(array(
            'plate' => $customerData->plate,
            'model' => $customerData->model,
            'merk' => $customerData->merk,
            'chasis' => $customerData->chasis,
            'engine' => $customerData->engine,
            'km' => $customerData->km,
            'regdate' => $customerData->regdate,
            )
        );
    }

    public function actionDetail($id)
    {
        $model = TbEstimation::findOne($id);

        // services array
        $allServices = TbEstimationService::find()
                    ->where(['id_tb_estimation' => $model->id])
                    ->orderBy(['qty' => SORT_DESC])
                    ->all();

        // total price
        $sum = TbEstimationService::find()
            ->where(['id_tb_estimation' => $model->id])
            ->sum('amount');

        $customer = TbCustomer::find()->where(['id' => $model->id_customer])->one();
        
        return $this->renderAjax('_detail', [
            'model' => $model,
            'customer' => $customer,
            'allServices' => $allServices,
            'sum' => $sum,
        ]);
    }

    public function actionGenerateWorkOrder($id) {
        // estimation
        $estimation = TbEstimation::findOne($id);
        $estimation->is_work_order = 1;
        $estimation->save();

        // work order - retrieve data from estimation
        $workOrder = new TbWorkOrder();
        $workOrder->no_work_order = $workOrder->generateWorkOrderNumber($estimation->id_customer);
        $workOrder->id_estimation = $estimation->id;
        $workOrder->id_customer = $estimation->id_customer;
        $workOrder->id_mechanic = $estimation->id_mechanic;
        $workOrder->broughtin = $estimation->broughtin;
        $workOrder->received = $estimation->received;
        $workOrder->datein = $estimation->datein;
        $workOrder->dateout = $estimation->dateout;
        $workOrder->generate_status = TbEstimation::FROM_ESTIMATION; // from estimation
        $workOrder->save(false);

        // store service to table service work order from service estimation
        $serviceEstimation = TbEstimationService::find()->where(['id_tb_estimation' => $estimation->id])->all();

        if (is_array($serviceEstimation)) {
            foreach ($serviceEstimation as $key => $value) {
                $service = new TbWorkOrderService();
                $service->id_tb_work_order = $workOrder->id;
                $service->name = $value->name;
                $service->qty = $value->qty;
                $service->price = $value->price;
                $service->amount = $value->amount;
                $service->save(false);
                
            }
        }

        Yii::$app->getSession()->setFlash('generate_work_order_success', [
                'type'     => 'success',
                'duration' => 5000,
                'title'    => 'System Information',
                'message'  => 'Berhasil membuat Work Order',
            ]
        );

        return $this->redirect(['view-work-order', 'id' => $estimation->id]);
    }

    public function actionViewWorkOrder($id)
    {
        $model = $this->findModel($id);

        $workOrder = $model->workOrder;
        
        return $this->render('view_work_order', [
            'model' => $this->findModel($id),
            'workOrder' => $workOrder,
        ]);
    }
}
