<?php

namespace api\models;

use Yii;
use yii\web\IdentityInterface;
use yii\filters\RateLimitInterface;
use common\models\base\User as BaseUser;
use common\models\Certificate;
/**
 * 实现User组件中的身份识别类 参见 yii\web\user
 * This is the model class for table "{{%credit_user}}".
 *
 */
class User extends BaseUser implements IdentityInterface, RateLimitInterface {

    //文件缓存限速
    public $allowance;
    public $allowance_updated_at;

    //禁用账号
    const STATUS_ACTIVE = 0; //启用
    const STATUS_DELETED = 1; //禁用
    /**
     * --------------------------------------------------------------
     * 实现IdentityInterface
     * 资料参考：http://www.yiichina.com/doc/guide/2.0/rest-authentication
     * --------------------------------------------------------------
     */

    /**
     * 根据UID获取账号信息
     */
    public static function findIdentity($uid) {
        return static::findOne(['id' => $uid, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * ---------------------------------------
     * 由token获取用户信息
     * @param mixed $token
     * @param null $type
     * @return null|static
     * ---------------------------------------
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        /* 使用 /api/v1/user?access-token=e282486518 即可访问 */
        return static::findOne(['token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * ---------------------------------------
     * 获取主键
     * @return mixed
     * ---------------------------------------
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * ---------------------------------------
     * 获取密码干扰字符串
     * @return string
     * ---------------------------------------
     */
    public function getAuthKey() {
        return $this->salt;
    }

    /**
     * ---------------------------------------
     * 验证
     * @param string $authKey
     * @return bool
     * ---------------------------------------
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * --------------------------------------------------------------
     * 实现RateLimitInterface
     * 以下是接口调用速率限制信息，记得在数据库中添加两个字段allowance,allowance_updated_at
     * 这两个字段也可以存储到缓存中，这里方便就存储到数据库中了
     * 资料参考：http://www.yiichina.com/doc/guide/2.0/rest-rate-limiting
     * --------------------------------------------------------------
     */

    /**
     * ---------------------------------------
     * 返回某一时间允许请求的最大数量，比如设置10秒内最多5次请求（小数量方便我们模拟测试）
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return array
     * ---------------------------------------
     */
    public function getRateLimit($request, $action) {
        return [10, 10];
    }

    /**
     * ---------------------------------------
     * 返回剩余的允许的请求和相应的UNIX时间戳数 当最后一次速率限制检查时
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return array
     * ---------------------------------------
     */
    public function loadAllowance($request, $action) {
        return [Yii::$app->cache->get(Yii::$app->user->id . '_allowance'), Yii::$app->cache->get(Yii::$app->user->id . '_allowance_updated_at')];
    }

    /**
     * ---------------------------------------
     * 保存允许剩余的请求数和当前的UNIX时间戳
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @param int $allowance
     * @param int $timestamp
     * ---------------------------------------
     */
    public function saveAllowance($request, $action, $allowance, $timestamp) {
        $this->allowance = Yii::$app->cache->set(Yii::$app->user->id . '_allowance', $allowance, 20);
        $this->allowance_updated_at = Yii::$app->cache->set(Yii::$app->user->id . '_allowance_updated_at', $timestamp, 20);
    }

    public function getCertificate(){
        return $this -> hasOne(Certificate::className(),['company_id' => 'id']);
    }

}
