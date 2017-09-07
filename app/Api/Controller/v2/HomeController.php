<?php

namespace App\Api\Controller\V2;

use App\Api\Controller\V1\BaseController;
use App\User;
use Dingo\Api\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class HomeController extends BaseController
{
    public function __construct ()
    {
        $this->middleware('api.auth');
        $this->middleware('api.auth', ['only' => ['index']]);
    }

    public function index (Request $request)
    {

        $user = $user = app('Dingo\Api\Auth\Auth')->user();
        return $this->response->array($user->toArray())->setStatusCode(200);
    }

    public function save()
    {
        $user = $user = app('Dingo\Api\Auth\Auth')->user();
        return $this->response->array($user->toArray())->setStatusCode(200);
    }
}