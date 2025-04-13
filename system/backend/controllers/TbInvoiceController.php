<?php

namespace backend\controllers;

use Yii;
use backend\models\TbInvoice;
use backend\models\TbInvoiceSearch;
use backend\models\TbInvoiceService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Model;
use backend\models\TbCustomer;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;

/**
 * TbInvoiceController implements the CRUD actions for TbInvoice model.
 */
class TbInvoiceController extends Controller
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
     * Lists all TbInvoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TbInvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbInvoice model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $serviceAmount = TbInvoiceService::find()->andWhere(['id_tb_invoice' => $model->id])->sum('amount');

        return $this->render('view', [
            'model' => $model,
            'serviceAmount' => $serviceAmount
        ]);
    }

    /**
     * Creates a new TbInvoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // estimasi model initial Load
        $model = new TbInvoice;

        // service model initial Load
        $serviceModel = [new TbInvoiceService];

        // customer Model Initial Load
        $customerModel = new TbCustomer();

        // customer ID From AJAX POST
        $customerId = Yii::$app->request->post('customer');

        if ($model->load(Yii::$app->request->post())) {
            
            $model->no_invoice = $model->generateInvoiceNumber($customerId);
            $model->id_customer = $customerId;
            $model->save();

            // service validation
            $serviceModel = Model::createMultiple(TbInvoiceService::classname());
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
                            
                            $item->id_tb_invoice = $model->id;

                            if ($item->qty !== null && is_numeric($item->qty) && $item->price !== null && is_numeric($item->price)) {
                                $item->amount = $item->qty * $item->price;
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
                'serviceModel' => (empty($serviceModel)) ? [new TbInvoiceService] : $serviceModel
            ]);
        }
    }

    /**
     * Updates an existing TbInvoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $serviceModel = $model->serviceItems;

        // customer ID From AJAX POST
        $customerId = Yii::$app->request->post('customer');

        if ($model->load(Yii::$app->request->post())) {

            $model->no_invoice = $model->generateInvoiceNumber($customerId);
            $model->id_customer = $customerId;
            $model->save();

            $oldIDs = ArrayHelper::map($serviceModel, 'id', 'id');
            $serviceModel = Model::createMultiple(TbInvoiceService::classname(), $serviceModel);
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
                                TbInvoiceService::deleteAll(['id' => $deletedIDs]);
                            }
                            if (! ($flag = $item->save(false))) {
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
                'serviceModel' => (empty($serviceModel)) ? [new TbInvoiceService] : $serviceModel
            ]);
        }
    }

    /**
     * Deletes an existing TbInvoice model.
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
     * Finds the TbInvoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbInvoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TbInvoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrintInvoice($id)
    {
        $model = TbInvoice::findOne($id);

        $allServices = TbInvoiceService::find()
                    ->where(['id_tb_invoice' => $model->id])
                    ->orderBy(['qty' => SORT_DESC])
                    ->all();

        $sum = TbInvoiceService::find()->where(['id_tb_invoice' => $model->id])->sum('amount');

        $content = $this->renderPartial('/tb-invoice/print/invoice', [
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
            font-weight: bold;
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
            'options' => ['title' => 'Invoice Order'],
            'methods' => [
                'SetHeader'=> [null],
                'SetFooter'=> [null]
            ]
        ]);

        $date = date('d-m-Y His');
        $pdf->filename = "Invoice - ".$date.".pdf";
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
        $model = TbInvoice::findOne(['id' => $id]);

        $customer = TbCustomer::find()->where(['id' => $model->id_customer])->one();

        $allServices = TbInvoiceService::find()
                    ->where(['id_tb_invoice' => $model->id])
                    ->orderBy(['qty' => SORT_DESC])
                    ->all();

        $sum = TbInvoiceService::find()->where(['id_tb_invoice' => $model->id])->sum('amount');

        return $this->renderAjax('_detail', [
            'model' => $model,
            'customer' => $customer,
            'allServices' => $allServices,
            'sum' => $sum,
        ]);
    }

    public function actionEditStatus($id, $is_out)
    {
        $model = $this->findModel($id);
        $model->is_out = $is_out;

        if ($model->save(false)) {
            Yii::$app->getSession()->setFlash('invoice_payment_success', [
                'type'     => 'success',
                'duration' => 5000,
                'title'    => 'Payment Status',
                'message'  => 'Invoice berhasil di bayar!',
            ]);
            return $this->redirect(Yii::$app->request->referrer);
        }
        else
        {
            if ($model->errors)
            {
                $message = "";
                foreach ($model->errors as $key => $value) {
                    foreach ($value as $key1 => $value2) {
                        $message .= $value2;
                    }
                }
                Yii::$app->getSession()->setFlash('invoice_payment_failed', [
                        'type'     => 'error',
                        'duration' => 5000,
                        'title'  => 'Error',
                        'message'  => $message,
                    ]
                );
            }
        }
    }
}
