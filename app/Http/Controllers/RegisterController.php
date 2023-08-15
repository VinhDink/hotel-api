<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register user
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function register(RegisterRequest $request)
    {
        try {
            $result = $this->userService->store($request->validated());
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('register.register_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['user' => $result]);
    }
}
