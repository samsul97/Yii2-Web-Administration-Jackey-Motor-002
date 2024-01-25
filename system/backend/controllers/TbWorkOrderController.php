<?php

namespace backend\controllers;

use Yii;
use backend\models\Model;
use backend\models\TbWorkOrder;
use backend\models\TbCustomer;
use backend\models\TbEstimation;
use backend\models\TbInvoice;
use backend\models\TbInvoiceService;
use backend\models\TbMechanic;
use backend\models\TbWorkOrderService;
use backend\models\TbWorkOrderSearch;
use kartik\mpdf\Pdf;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * TbWorkOrderController implements the CRUD actions for TbWorkOrder model.
 */
class TbWorkOrderController extends Controller
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
     * Lists all TbWorkOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TbWorkOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbWorkOrder model.
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
     * Creates a new TbWorkOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // work order model initial Load
        $model = new TbWorkOrder;

        // service model initial Load
        $serviceModel = [new TbWorkOrderService];

        // customer Model Initial Load
        $customerModel = new TbCustomer();

        // customer ID From AJAX POST
        $customerId = Yii::$app->request->post('customer');

        if ($model->load(Yii::$app->request->post())) {
            
            $model->no_work_order = $model->generateWorkOrderNumber($customerId);
            $model->id_customer = $customerId;
            $model->save();

            // service validation
            $serviceModel = Model::createMultiple(TbWorkOrderService::classname());
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

                            $item->id_tb_work_order = $model->id;

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
                        return $this->redirect(['index']);
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
                'serviceModel' => (empty($serviceModel)) ? [new TbWorkOrderService] : $serviceModel
            ]);
        }
    }

    /**
     * Updates an existing TbWorkOrder model.
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
        
        // existing service data
        $serviceModel = $model->serviceItems;

        if ($model->load(Yii::$app->request->post())) {
            $model->id_customer = $customerId;
            $model->save();

            $oldIDs = ArrayHelper::map($serviceModel, 'id', 'id');
            $serviceModel = Model::createMultiple(TbWorkOrderService::classname(), $serviceModel);
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
                            $item->id_tb_work_order = $model->id;
                            if ($item->qty !== null && is_numeric($item->qty) && $item->price !== null && is_numeric($item->price)) {

                                $item->amount = $item->qty * $item->price;
                            }

                            if (!empty($deletedIDs)) {
                                TbWorkOrderService::deleteAll(['id' => $deletedIDs]);
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
        else {
            return $this->render('update', [
                'model' => $model,
                'serviceModel' => (empty($serviceModel)) ? [new TbWorkOrderService] : $serviceModel,
            ]);
        }
    }

    /**
     * Deletes an existing TbWorkOrder model.
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
     * Finds the TbWorkOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbWorkOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TbWorkOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrintWorkingOrder($id)
    {
        $model = TbWorkOrder::findOne($id);

        $allServices = TbWorkOrderService::find()
                    ->where(['id_tb_work_order' => $model->id])
                    ->orderBy(['qty' => SORT_DESC])
                    ->all();

        $sumAmount = TbWorkOrderService::find()
                    ->andWhere(['id_tb_work_order' => $model->id])
                    ->sum('amount');

        $content = $this->renderPartial('/tb-work-order/print/working-order', [
            'model' => $model,
            'allServices' => $allServices,
            'sumAmount' => $sumAmount,
        ]);
        
        $cssInline = <<< CSS
            .table1 {
                font-family: sans-serif;
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
            'marginLeft' => 5,
            'marginRight' => 5,
            'marginTop' => 4,
            'format' => [210,297],
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssInline' => $cssInline,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => ['title' => 'Working Order'],
            'methods' => [
                'SetHeader'=> [null],
                'SetFooter'=> [null],
            ]
        ]);
        $date = date('d-m-Y His');
        $pdf->filename = "Work Order - ". $date . '-' . $model->customer->name .".pdf";
        return $pdf->render();
    }

    public function actionDetail($id)
    {
        $model = TbWorkOrder::findOne($id);

        // services array
        $allServices = TbWorkOrderService::find()
                    ->where(['id_tb_work_order' => $model->id])
                    ->orderBy(['qty' => SORT_DESC])
                    ->all();

        $customer = TbCustomer::find()->where(['id' => $model->id_customer])->one();
        
        return $this->renderAjax('_detail', [
            'model' => $model,
            'customer' => $customer,
            'allServices' => $allServices,
        ]);
    }

    public function actionGenerateInvoice($id) {
        // work order
        $workOrder = TbWorkOrder::findOne($id);
        $workOrder->is_invoice = TbInvoice::IS_INVOICE;
        $workOrder->save();

        // estimation
        if ($workOrder->id_estimation) { // jika punya nilai dari estimasi
            $estimation = TbEstimation::find()->where(['id' => $workOrder->id_estimation])->one();
            $estimation->is_invoice = TbInvoice::IS_INVOICE;
            $estimation->save();
        }

        // invoice - retrieve data from work order
        $invoice = new TbInvoice();
        $invoice->id_work_order = $workOrder->id;
        $invoice->id_customer = $workOrder->id_customer;
        $invoice->id_mechanic = $workOrder->id_mechanic;
        $invoice->no_invoice = $invoice->generateInvoiceNumber($workOrder->id_customer);
        $invoice->broughtin = $workOrder->broughtin;
        $invoice->received = $workOrder->received;
        $invoice->datein = $workOrder->datein;
        $invoice->dateout = $workOrder->dateout;
        if ($workOrder->id_estimation) {
            $invoice->generate_status = TbInvoice::FROM_WORK_ORDER_AND_ESTIMATION;
        }
        $invoice->save(false);

        // store service to table service invoice from service work order
        $serviceWorkOrder = TbWorkOrderService::find()->where(['id_tb_work_order' => $workOrder->id])->all();

        if (is_array($serviceWorkOrder)) {
            foreach ($serviceWorkOrder as $key => $value) {
                $service = new TbInvoiceService();
                $service->id_tb_invoice = $invoice->id;
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

        return $this->redirect(['/tb-invoice/view', 'id' => $invoice->id]);
    }
}
