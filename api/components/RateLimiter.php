<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace api\components;

use yii\filters\RateLimiter as BaseRateLimiter;
use common\models\JsonYll;
/**
 * Description of newPHPClass
 *
 * @author u
 */
class RateLimiter extends BaseRateLimiter{

    public function checkRateLimit($user, $request, $response, $action)
    {
        $current = time();

        list ($limit, $window) = $user->getRateLimit($request, $action);
        list ($allowance, $timestamp) = $user->loadAllowance($request, $action);

        $allowance += (int) (($current - $timestamp) * $limit / $window);
        if ($allowance > $limit) {
            $allowance = $limit;
        }

        if ($allowance < 1) {
            $user->saveAllowance($request, $action, 0, $current);
            $this->addRateLimitHeaders($response, $limit, 0, $window);
            $response -> statusCode = 429;
            $response -> data = JsonYll::encode('0', '请求过多,请在' . $window . '秒后重试.', [], '429');
            $response -> send();
        } else {
            $user->saveAllowance($request, $action, $allowance - 1, $current);
            $this->addRateLimitHeaders($response, $limit, $allowance - 1, (int) (($limit - $allowance) * $window / $limit));
        }
    }
}
