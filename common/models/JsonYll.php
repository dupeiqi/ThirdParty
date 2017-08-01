<?php

namespace common\models;

use Yii;
use yii\web\NotFoundHttpException;

class JsonYll extends \yii\base\Model {

    const SUCCESS = '1';
    const FAIL = '0';
    
    
    /**
     * 
     * @param type $status 状态码
     * @param type $msg    提示信息
     * @param type $data   传递数据
     * @return type
     */
    public static function jsonEncodeYll($status = 0, $msg = '', $data = []) {

        return json_encode(['status' => $status, 'msg' => $msg, 'data' => $data]);
    }

    public static function requestErrorYll() {
        return self::jsonEncodeYll('0', '当前请求类型不符合要求');
    }
    
    /**
     * 
     * @param type $code    提示码(0:失败;1:成功)
     * @param type $msg     提示信息
     * @param type $data    传递数据
     * @param type $status  状态码
     * @return array
     */
    public static function encode($code = '0', $msg = '', $data = [], $status = 200) {
        return ['status' => $status, 'message' => $msg, 'data' => $data, 'code' => $code];
    }

}
