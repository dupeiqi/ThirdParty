<?php

namespace common\models;

use Yii;
use common\models\base\FddTemplate as BaseFddTemplate;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class FddTemplate extends BaseFddTemplate
{
      public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }
    
//     public function saveTemp(){
//         
//        $this->created_at=$this->updated_at=time();
//        $this->token=md5($this->company_name.$this->created_at);
//         
//     }
    //获取默认模版
    public function defaultTemplate($user_id,$template_id){
 
        if (empty($user_id)){
            return false;
        }
        
         if (empty($template_id)) {
            
            $count_rec = static::find()->where(['user_id' => $user_id, 'visible' => 1])->count();
            if ($count_rec == 1) {  //是为公司唯一一个模版
                $tp_rec = static::find()->where(['user_id' => $user_id, 'visible' => 1])->select(array('id', 'template_id', 'template_name', 'template_file','sign_keyword','params'))->one();
                if (empty($tp_rec->id)) {
                    return false;
                }
            } else {
                return false;
            }
            return $tp_rec;
        } else {
            //判断用户模版是否存在
            $tp_rec = static::find()->where(['user_id' => $user_id, 'template_id' => $template_id, 'visible' => 1])->select(array('id', 'template_id', 'template_name', 'template_file','sign_keyword','params'))->one();

            if (empty($tp_rec->id)) {
                return JsonYll::encode('40010', '您传的模版ID不误！.', [], '200');
            }
            return $tp_rec;
        }
    }
}
