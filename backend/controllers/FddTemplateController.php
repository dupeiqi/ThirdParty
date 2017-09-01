<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\FddTemplate;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\FddApi;
use common\models\DataDict;
/**
 * UserController implements the CRUD actions for User model.
 */
class FddTemplateController extends Controller
{
   
    public $file_path;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action){
        $this->file_path=\Yii::$app->params['fddConfig']['file_path'];
        return true;
    }
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => FddTemplate::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
     
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new FddTemplate();      

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            
            
          
            $template_file = UploadedFile::getInstances($model, 'template_file');
            if ($template_file) {
                foreach ($template_file as $file) {
                    //文件名
                    $fileName = date("YmdHiiHsHis") . mt_rand(100, 999) . "." . $file->extension;

                    if ($file->saveAs($this->file_path . "/" . $fileName)) {
                        $model->template_file = "" . $fileName;
                    }
                }
            }
            $model->params= json_encode($model->params);
            if ($model->validate()) {
                 $template_id = "TP" . $this->getRand();
                $model->template_id = $template_id;
                //    $model->save();
                $file = $this->file_path . "/" . $model->template_file;

                //请求法大大接口
                $fdd = new FddApi();
                $jsondata = json_decode($fdd->invokeUploadTemplate($template_id, $file,''), true);
       
                if ($jsondata['code'] == '1') {
                   //保存模版数据 
                   $model->save();
                   
                } else {
                    Yii::$app->getSession()->setFlash('error',"上传模版错误：".$jsondata['msg']);
                    return $this->redirect(['create']);
                }
              
            }
           
            return $this->redirect(['view', 'id' => $model->id]);
            exit;
        }
      
        $allParams = DataDict::find() -> select(['dict_name','id','dict_value']) -> indexBy('id') -> all();
       
        $data = User::find()->All();
        if (!empty($data->params)){
             $dataDict= json_decode($data->params,true);
        }else{
             $dataDict= array();
        }
       
        return $this->render('create', [
                    'model' => $model,
                    'allParams'=>$allParams,
                    'dataDict'=>$dataDict,
                    'data' => $data,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $template_file = UploadedFile::getInstances($model, 'template_file');

            if (!empty($template_file)) {
                foreach ($template_file as $file) {
                    //文件名
                    $fileName = date("YmdHiiHsHis") . mt_rand(100, 999) . "." . $file->extension;

                    if ($file->saveAs($this->file_path.'/' . $fileName)) {

                        $model->template_file = "uploads/" . $fileName;
                    }
                }
            } else {
                unset($model->template_file);
            }
            $model->params= json_encode($model->params);
            if ($model->validate()) {

                $model->update();
            }

            return $this->redirect(['view', 'id' => $model->id]);
            exit;
        }

        $data = User::find()->All();
        if (!empty($model->params)) {
            $dataDict = json_decode($model->params, true);
        } else {
            $dataDict = array();
        }
      
        $allParams = DataDict::find()->select(['dict_name', 'id', 'dict_value'])->indexBy('id')->all();


       
        return $this->render('update', [
                    'model' => $model,
                    'allParams'=>$allParams,
                    'dataDict'=>$dataDict,
                    'data' => $data,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FddTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
     protected function getRand()
    {
        $time = explode (" ", microtime () );
        $time = $time [1] . str_pad(round($time [0] * 1000),3,'0',STR_PAD_RIGHT);
        $time2 = explode ( ".", $time );
        $time = $time2 [0];
        $time.=rand(100,999);
        return $time;
    }
}
