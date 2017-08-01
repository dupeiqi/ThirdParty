<?php


namespace api\components;

use yii\web\UnauthorizedHttpException;
use common\models\JsonYll;

/**
 * QueryParamAuth is an action filter that supports the authentication based on the access token passed through a query parameter.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class QueryParamAuth extends \yii\filters\auth\AuthMethod {

    /**
     * @var string the parameter name for passing the token 
     * rename access-token token 
     */
    public $tokenParam = 'token';

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response) {
        $accessToken = $request->get($this->tokenParam);
        if (is_string($accessToken)) {
            $identity = $user->loginByAccessToken($accessToken, get_class($this));
            if ($identity !== null) {
                return $identity;
            }
        }
        if ($accessToken !== null) {
            $this->handleFailure($response);
        }

        return null;
    }
    
    public function handleFailure($response)
    {
        $response -> statusCode = 401;
        $response -> data = JsonYll::encode(JsonYll::FAIL, 'Token不正确', [], '401');
        $response -> send();
    }

}
