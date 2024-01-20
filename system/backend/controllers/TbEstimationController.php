<?php

namespace backend\controllers;

use Yii;
use backend\models\TbEstimation;
use backend\models\TbCustomer;
use backend\models\TbService;
use backend\models\TbEstimationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Model;
use backend\models\TbInvoice;
use backend\models\TbServiceEstimation;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseStringHelper;
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
    public function actionCreate($idCustomer = null)
    {
        // estimasi model initial Load
        $model = new TbEstimation;

        // service model initial Load
        $serviceModel = [new TbServiceEstimation];

        // customer Model Initial Load
        $customerModel = new TbCustomer();

        // customer ID From AJAX POST
        $customerId = Yii::$app->request->post('customer');

        if ($model->load(Yii::$app->request->post())) {
            
            $model->no_estimation = $model->generateEstimationNumber($customerId);
            $model->id_customer = $customerId;
            $model->save();

            // service validation
            $serviceModel = Model::createMultiple(TbServiceEstimation::classname());
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
                'serviceModel' => (empty($serviceModel)) ? [new TbServiceEstimation] : $serviceModel
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
        
        $serviceModel = $model->orderItems;

        if ($model->load(Yii::$app->request->post())) {
            
            $model->no_estimation = $model->generateEstimationNumber($customerId);
            $model->id_customer = $customerId;
            $model->save();

            $oldIDs = ArrayHelper::map($serviceModel, 'id', 'id');
            $serviceModel = Model::createMultiple(TbServiceEstimation::classname(), $serviceModel);
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
                        foreach ($serviceModel as $modelAddress) {
                            $modelAddress->id_tb_estimation = $model->id;
                            if ($modelAddress->qty !== null && is_numeric($modelAddress->qty) && $modelAddress->price !== null && is_numeric($modelAddress->price)) {

                                $modelAddress->amount = $modelAddress->qty * $modelAddress->price;
                            }

                            if (! empty($deletedIDs)) {
                                TbServiceEstimation::deleteAll(['id' => $deletedIDs]);
                            }

                            if (! ($flag = $modelAddress->save(false))) {
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

        else {
        //     print_r($serviceModel);
        // die;
            return $this->render('update', [
                'model' => $model,
                'serviceModel' => (empty($serviceModel)) ? [new TbServiceEstimation] : $serviceModel,
                // 'customerModel' => $customerModel,
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
        $allServices = TbServiceEstimation::find()
                    ->where(['id_tb_estimation' => $model->id])
                    ->orderBy(['qty' => SORT_DESC])
                    ->all();

        // total price
        $sum = TbServiceEstimation::find()
                ->where(['id_tb_estimation' => $model->id])
                ->sum('amount');
        
        $content = $this->renderPartial('/tb-invoice/print/estimation', [
                    'model' => $model,
                    'allServices' => $allServices,
                    'id' => $id,
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
            )
        );
    }

    public function actionDetail($id)
    {
        $model = TbEstimation::findOne($id);

        // services array
        $allServices = TbServiceEstimation::find()
                    ->where(['id_tb_estimation' => $model->id])
                    ->orderBy(['qty' => SORT_DESC])
                    ->all();

        // total price
        $sum = TbServiceEstimation::find()
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

    public function actionGenerateInvoice($id) {
        // estimation
        $estimation = TbEstimation::findOne($id);
        $estimation->is_invoice = 1;
        $estimation->save();

        // invoice - retrieve data from estimation
        $invoice = new TbInvoice();
        $invoice->id_estimation = $estimation->id;
        $invoice->id_customer = $estimation->id_customer;
        $invoice->id_mechanic = $estimation->id_mechanic;
        $invoice->no_invoice = $invoice->generateInvoiceNumber($estimation->id_customer);
        $invoice->broughtin = $estimation->broughtin;
        $invoice->received = $estimation->received;
        $invoice->regdate = $estimation->regdate;
        $invoice->datein = $estimation->datein;
        $invoice->dateout = $estimation->dateout;
        $invoice->km = $estimation->km;
        $invoice->is_invoice = 1; // from estimation
        $invoice->save(false);

        // store service to table service invoice from service estimation
        $serviceEstimation = TbServiceEstimation::find()->where(['id_tb_estimation' => $estimation->id])->all();

        if (is_array($serviceEstimation)) {
            foreach ($serviceEstimation as $key => $value) {
                $service = new TbService();
                $service->id_tb_estimation = $estimation->id;
                $service->id_tb_invoice = null;
                $service->name = $value->name;
                $service->qty = $value->qty;
                $service->price = $value->price;
                $service->amount = $value->amount;
                $service->save(false);
                
            }
        }

        Yii::$app->getSession()->setFlash('generate_invoice_success', [
                'type'     => 'success',
                'duration' => 5000,
                'title'    => 'System Information',
                'message'  => 'Berhasil membuat Invoice',
            ]
        );

        return $this->redirect(['/tb-invoice/index']);
    }

    public function actionCheckInvoice($id) {

        $estimation = $this->findModel($id);
        
        $model = TbInvoice::find()->where(['id_estimation' => $estimation->id])->one();
        
        $serviceModel = $model->orderItems;

        // customer ID From AJAX POST
        $customerId = Yii::$app->request->post('customer');

        if ($model->load(Yii::$app->request->post())) {

            $model->no_invoice = $model->generateInvoiceNumber($customerId);
            $model->id_customer = $customerId;
            $model->save();

            $oldIDs = ArrayHelper::map($serviceModel, 'id', 'id');
            $serviceModel = Model::createMultiple(TbService::classname(), $serviceModel);
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

                            if ($model->is_invoice == 1) { // from estimation
                                $item->id_tb_estimation = $model->id;
                            } else { // invoice
                                $item->id_tb_invoice = $model->id;
                            }

                            if ($item->qty !== null && is_numeric($item->qty) && $item->price !== null && is_numeric($item->price)) {
                                $item->amount = $item->qty * $item->price;
                            }
                            if (! empty($deletedIDs)) {
                                TbService::deleteAll(['id' => $deletedIDs]);
                            }
                            if (! ($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['/tb-invoice/index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        else {
            return $this->render('/tb-invoice/update', [
                'model' => $model,
                'serviceModel' => (empty($serviceModel)) ? [new TbService] : $serviceModel
            ]);
        }
    }
}
