<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;

class UsersController extends BaseApiController
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
     * Get a listing of the users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return $this->ok(User::paginate(10));
    }

    /**
     * Get specific user in storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(User $user)
    {
        return $this->ok($user);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $user = $this->userService->create(collect($request->all()));

        return $this->ok($user);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $user = $this->userService->update($user, collect($request->all()));

        return $this->ok($user);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->modelDeleted('User');
    }
}
