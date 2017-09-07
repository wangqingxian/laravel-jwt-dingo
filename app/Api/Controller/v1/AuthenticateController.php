<?php
/**
 * Created by PhpStorm.
 * User: wangqingxian
 * Date: 2017/9/7
 * Time: 15:24
 */

namespace App\Api\Controller\V1;
use Illuminate\Http\Request;
use Dingo\Api\Console\Command\Cache;
use Dingo\Api\Contract\Http\Validator;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthenticateController extends BaseController
{

    public function __construct ()
    {
    }

    //注册
    public function register(Request $request)
    {

        $payload = $request->only('name', 'phone', 'password','email');


        // 创建用户
        $result = User::create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
            'password' => bcrypt($payload['password']),
        ]);

        if ($result) {
            return $this->response->array(['success' => '创建用户成功'])->setStatusCode(200);
        } else {
            return $this->response->array(['error' => '创建用户失败']);
        }
    }

    //创建token
    public function authenticate(Request $request)
    {
        $payload = $request->only('phone', 'password');

        try {
            if (! $token = JWTAuth::attempt($payload)) {
                return $this->response->array(['error' => 'token已经失效']);
            } else {
                return $this->response->array(['token' => $token]);
            }
        } catch (JWTException $e) {
            return $this->response->array(['error' => '不能创建token']);
        }
    }
    //销毁token
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());    //token加入黑名单(注销)
        return $this->response->array(['success' => 'logout success'])->setStatusCode(200);

    }


    //刷新token
    public function refresh()
    {
        $old_token=JWTAuth::gettoken();    //获取过期token
        $new_token=JWTAuth::refresh($old_token);    //刷新token并返回
        //JWTAuth::invalidate($old_token);    //销毁过期token
        return $this->response->array([
            'token'=>$new_token,
            'status_code'=>201
        ]);
    }
}