<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Api\BaseApiController;

class RegisterController extends BaseApiController
{
    /**
     * @var \App\Services\UserService
     */
    protected $userService;

    /**
     * Constructor.
     *
     * @param  \App\Services\UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle a user registration request.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $request)
    {
        $user = $this->userService->create(collect($request->all()));

        return $this->ok($user);
    }
}
