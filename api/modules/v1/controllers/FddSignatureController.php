<?php
namespace api\modules\v1\controllers;
use Yii;
use yii\rest\ActiveController;
use common\models\JsonYll;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use api\components\QueryParamAuth;
use common\models\FddApi;
use common\models\FddContract;
use common\models\FddSignature;

class FddSignatureController extends ActiveController{
    
    public $modelClass = 'common\models\FddSignature';
    //文件路途
    public $pathfile;
    //页面跳转
    public  $return_url='http://api.signature.com/v1/fddurl/return-url';
    
    public function behaviors()
    {
        $parent = parent::behaviors();
        $son = [
            'authenticator' => [
                'class' => QueryParamAuth::className()
            ],

            'contentNegotiator' => [
                'formats' => [
                    'text/html' => Response::FORMAT_JSON,
                ]
            ]
        ];
        $this->pathfile=\Yii::$app->params['fddConfig']['file_path'];
        return ArrayHelper::merge($parent, $son);
    }
    

    
     /**
     * 文档传输接口
     */
    public function actionContract() {
        
        $doc_title=Yii::$app->request->post('doc_title');   
       
        if (empty($doc_title)){   
            return JsonYll::encode('40010', '合同标题不能为空.', [], '200');           
        }
        $contract_id="HT".$this->getRand();       
        
        $upfile = $_FILES['file'];
        $fileArray = pathinfo($upfile['name']);
        $fileExtension = $fileArray['extension'];
        
        if (strtolower($fileExtension)!='pdf'){
            return JsonYll::encode('40010', '上传的合同文件必须PDF.', [], '200');
         }         
         
        //文件上传存放的目录
        $dir = $this->pathfile."/" . date("Ymd");
        if (!is_dir($dir))
            mkdir($dir);
       
        //文件名
        $fileName = date("YmdHiiHsHis") . mt_rand(100, 999) . "." . $fileArray['extension'];
        $dir = $dir . "/" . $fileName;
        move_uploaded_file($upfile['tmp_name'], $dir);
        $uploadSuccessPath = $this->pathfile."/" . date("Ymd") . "/" . $fileName;
        
        //保存文件合同
        $model=new FddContract();
        $model->user_id=Yii::$app->user->id;
        $model->contract_id=$contract_id;
        $model->doc_title=$doc_title;
        $model->file=$uploadSuccessPath;
        $model->timestamp=date("YmdHis");   
        $contractStatus=$model->save();
        
        if ($contractStatus){
            //请求法大大接口
            $fdd=new FddApi();
            $jsondata= json_decode($fdd->invokeUploadDocs($contract_id, $doc_title,'.pdf', $uploadSuccessPath,''),true);
            if ($jsondata['code']=='1000'){
                
                $model->status=1;
                $model->save();
                return JsonYll::encode(JsonYll::SUCCESS, '合同上传成功！', ['contract_id'=>$contract_id,'doc_title'=>$doc_title], '200');
            }else{
                return JsonYll::encode('40011',$jsondata['msg'], ['contract_id'=>$contract_id,'doc_title'=>$doc_title], '200');
            }
            
        }        
        return JsonYll::encode(JsonYll::FAIL, '数据保存失败，请联系管理员.', [], '200');

       
        
    }
    
    

     /**
     * 文档签署接口（手动签）

     */
    public function actionSign() {

        $doc_title = Yii::$app->request->post('doc_title');

        if (empty($doc_title)) {
            return JsonYll::encode('40010', '签署标题不能为空.', [], '200');
        }

        $contract_id = Yii::$app->request->post('contract_id');
        if (empty($contract_id)) {
            return JsonYll::encode('40010', '签署合同编号不能为空.', [], '200');
        }
        $rsContract = FddContract::findOne(['contract_id' => $contract_id, "status" => 1]);
        $return_url = trim($this->return_url);
        $customer_id = Yii::$app->user->identity->fdd_ca;

        if (empty($customer_id)) {
            return JsonYll::encode('40010', '签署客户编号CA不能为空.', [], '200');
        }
        $sign_keyword = Yii::$app->request->post('sign_keyword');

        $transaction_id = "SG" . $this->getRand();

        //保存签署合同
        
        $model=FddSignature::find()->where(['user_id'=>Yii::$app->user->id,'contract_id'=>$contract_id])->one();       
        if (!empty($model->id)){
            if ($model->status==1){
                return JsonYll::encode(JsonYll::FAIL, '些合同您已经签署过了.', [], '200');
            }
        }else{
            $model=new FddSignature();
        }
        
        $model->user_id = Yii::$app->user->id;
        $model->transaction_id = $transaction_id;
        $model->contract_id = $contract_id;
        $model->customer_id = $customer_id;
        $model->doc_title = $doc_title;
        $model->client_role = 1;
        $model->sign_keyword = $sign_keyword?$sign_keyword:'';
        $signStatus = $model->save();
        if ($signStatus) {
            $fdd = new FddApi();
            $get_url = $fdd->invokeExtSign($transaction_id, $customer_id, $contract_id, $doc_title, $return_url, $sign_keyword);

            return JsonYll::encode(JsonYll::SUCCESS, '文档签署网址返回成功！', ['fdd_url' => $get_url], '200');
        } else {
            return JsonYll::encode(JsonYll::FAIL, '数据保存失败，请联系管理员.', [], '200');
        }
    }

    /**
     * 文档签署接口（自动签）
   
     */
     public function actionAutoSign(){
       
        $doc_title = Yii::$app->request->post('doc_title');

        if (empty($doc_title)) {
            return JsonYll::encode('40010', '签署标题不能为空.', [], '200');
        }

        $contract_id = Yii::$app->request->post('contract_id');
        if (empty($contract_id)) {
            return JsonYll::encode('40010', '签署合同编号不能为空.', [], '200');
        }
        $rsContract = FddContract::findOne(['contract_id' => $contract_id, "status" => 1]);
        $return_url = trim($this->return_url);
        $customer_id = Yii::$app->user->identity->fdd_ca;

        if (empty($customer_id)) {
            return JsonYll::encode('40010', '签署客户编号CA不能为空.', [], '200');
        }
        $sign_keyword = Yii::$app->request->post('sign_keyword');
        if (empty($sign_keyword)) {
            return JsonYll::encode('40010', '定位关键字不能为空.', [], '200');
        }
        
        $client_role = Yii::$app->request->post('client_role');
        $client_role = $client_role?$client_role:1;
        $transaction_id = "SG" . $this->getRand();

        //保存签署合同

        $model=FddSignature::find()->where(['user_id'=>Yii::$app->user->id,'contract_id'=>$contract_id])->one();       
        if (!empty($model->id)){
            if ($model->status==1){
                return JsonYll::encode(JsonYll::FAIL, '些合同您已经签署过了.', [], '200');
            }
        }else{
            $model=new FddSignature();
        }
       
        $model->user_id = Yii::$app->user->id;
        $model->transaction_id = $transaction_id;
        $model->contract_id = $contract_id;
        $model->customer_id = $customer_id;
        $model->doc_title = $doc_title;
        $model->client_role = $client_role;
        $model->sign_keyword = $sign_keyword?$sign_keyword:'';
        $model->timestamp=date("YmdHis");
        $signStatus = $model->save();
        if ($signStatus) {
           
            $fdd = new FddApi();
            $notify_url='';
           
            $ret= json_decode($fdd->invokeExtSignAuto($transaction_id, $customer_id, $client_role, $contract_id, $doc_title, $sign_keyword, $notify_url),true);
           
            if ($ret['code']=='1000'){
                $model->download_url = $ret['download_url'];
                $model->viewpdf_url = $ret['viewpdf_url'];               
                $model->status = 1;
                $model->save();
                return JsonYll::encode(JsonYll::SUCCESS, '签署成功！', ['transaction_id'=>$transaction_id,'download_url'=>$ret['download_url'],'viewpdf_url'=>$ret['viewpdf_url']], '200');
           
            }else{
                return JsonYll::encode('40010',$ret['msg'], ['transaction_id'=>$transaction_id], '200');
            }
           
        } else {
            return JsonYll::encode(JsonYll::FAIL, '数据保存失败，请联系管理员.', [], '200');
        }
        
        
    }
      /**
     * 合同归档接口

     */
     public function actionFiling() {

        $contract_id = Yii::$app->request->post('contract_id');
        if (empty($contract_id)) {
            return JsonYll::encode('40010', '签署合同编号不能为空.', [], '200');
        }

        $model = FddContract::findOne(['contract_id' => $contract_id, 'user_id' => Yii::$app->user->id]);
        if (empty($model->id)) {
            return JsonYll::encode('40010', '结案合同不是您发起的!', [], '200');
        }

        $fdd = new FddApi();
        $ret = json_decode($fdd->invokeContractFilling($contract_id), true);
        if ($ret['code'] == '1000') {
            //更改合同状态
            $model->status = 2;
            $model->save();
            return JsonYll::encode(JsonYll::SUCCESS, '合同归档成功！', ['contract_id' => $contract_id], '200');
        } else {
            return JsonYll::encode('40010', $ret['msg'], ['contract_id' => $contract_id], '200');
        }
    }

    /**
     * 查看签署文件

     */
     public function actionShow(){
       
        $user_id=Yii::$app->user->id;
        $transaction_id=Yii::$app->request->post("transaction_id");
        if (empty($transaction_id)) {
            return JsonYll::encode('40010', '交易号不能为空.', [], '200');
        }
        $model=FddSignature::findOne(['transaction_id'=>$transaction_id,'user_id'=>$user_id]);
        if (!empty($model->id)){
             $data=array();
             $data['doc_title']=$model->doc_title;
             $data['contract_id']=$model->contract_id;
             $data['download_url']=$model->download_url;
             $data['viewpdf_url']=$model->viewpdf_url;
             
             return JsonYll::encode(JsonYll::SUCCESS,'查询成功',$data, '200');
        }else{
             return JsonYll::encode('40010', '查无此签署文件!.', [], '200');
        }
       
        
    }
    
    /**
     * 查看公司模版文件

     */
     public function actionTemplateShow(){
       
        $user_id=Yii::$app->user->id;

        if (empty($user_id)) {
            return JsonYll::encode('40010', '用户ID不能为空.', [], '200');
        }
        
        $model= \common\models\FddTemplate::find()->where(['user_id'=>$user_id,'visible'=>1])->select(array('id', 'template_id', 'template_name'))->all();
        return JsonYll::encode(JsonYll::SUCCESS,'查询成功',$model, '200');        
       
        
    }
      /**
     * 查看模版数据字典文件

     */
     public function actionDictShow(){
       
        $user_id=Yii::$app->user->id;

        if (empty($user_id)) {
            return JsonYll::encode(JsonYll::FAIL, '用户ID不能为空.', [], '40010');
        }
        //获取模版记录
        $template_id=Yii::$app->request->get("template_id");       
        
        $model=new \common\models\FddTemplate();
        $tp_rec = $model->defaultTemplate($user_id,$template_id);
      
        if (empty($tp_rec)) {
            return JsonYll::encode(JsonYll::FAIL, '模版ID不能为空.', [], '40010');
        }
    
        if (empty($tp_rec->params)){
             return JsonYll::encode(JsonYll::FAIL, '模版数据参数不能为空.', [], '40010');
        }else{
            $tp_data_dict= json_decode($tp_rec->params,true);
        }
        //模版字典        
        $dic_rec= \common\models\DataDict::find()->where(['in','id',$tp_data_dict])->select(array('id', 'dict_name', 'dict_value'))->all();
        
        return JsonYll::encode(JsonYll::SUCCESS,'查询成功',$dic_rec, '200');        
       
        
    }
    
    /**
     * 查看公司或个人是否签署

     */
     public function actionSignShow(){
       
        $user_id=Yii::$app->user->id;

        if (empty($user_id)) {
            return JsonYll::encode(JsonYll::FAIL, '用户ID不能为空.', [], '40010');
        }
        
        $id_card=Yii::$app->request->get("id_card");
        if (empty($id_card)) {
            return JsonYll::encode(JsonYll::FAIL, '个人用户身份证ID不能为空.', [], '40010');
        }
        $user_name=Yii::$app->request->get("user_name");
        if (empty($user_name)) {
            return JsonYll::encode(JsonYll::FAIL, '个人用户姓名不能为空.', [], '40010');
        }
        //获取模版记录
        $template_id=Yii::$app->request->get("template_id");
        $model=new \common\models\FddTemplate();
        $tp_rec = $model->defaultTemplate($user_id,$template_id);
      
        if (empty($tp_rec->template_id)) {
            return JsonYll::encode(JsonYll::FAIL, '模版ID不能为空.', [], '40010');
        }else{
            $template_id=$tp_rec->template_id;
        }
        //个人用户是否存在（添加法大大的CA）
        $user_rec= \common\models\GrUser::find()->where(['id_card'=>$id_card,'company_name'=>$user_name])->all();
       
        if (empty($user_rec[0]->id)) {
            return JsonYll::encode(JsonYll::FAIL, '没有找到该用户.', [], '40010');
        }
        foreach ($user_rec as $key=>$value){            
            $sign_user_id[]=$value['id'];
        }
        
        $model=FddContract::find()->where(['user_id'=>$user_id,'template_id'=>$template_id,'sign_user_id'=>$sign_user_id])->one();
         
        if (!empty($model->contract_id)){
            return JsonYll::encode(JsonYll::SUCCESS,'查询成功',['contract_id'=>$model->contract_id], '200');  
        }else{
            return JsonYll::encode(JsonYll::FAIL, '用户没有签署合同.', [], '40010'); 
        }
              
       
        
    }
    
    public function getRand()
    {
        $time = explode (" ", microtime () );
        $time = $time [1] . str_pad(round($time [0] * 1000),3,'0',STR_PAD_RIGHT);
        $time2 = explode ( ".", $time );
        $time = $time2 [0];
        $time.=rand(100,999);
        return $time;
    }
    
    
}