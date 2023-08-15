<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index()
    {
        try {
            $result = $this->userService->index();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('user.get_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(Request $request)
    {
        try {
            $this->userService->destroy($request->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('user.delete_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['message' => __('user.delete_success')]);
    }

    /**
     * Verify user's email
     *
     * @param  int  $id
     * @param  string  $hash
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail(Request $request, $id, $hash)
    {
        try {
            $result = $this->userService->verifyEmail($request->all(), $id, $hash);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('user.verify_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return redirect($result);
    }

    /**
     * Send reset password request
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function resetPassword(Request $request)
    {
        try {
            $result = $this->userService->resetPassword($request->all());
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('user.reset_password_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Set new password
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function setNewPassword(Request $request)
    {
        try {
            $result = $this->userService->setNewPassword($request->all());
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('user.reset_password_success')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result);
    }

    /**
     * Send link to user
     *
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function linkSent(Request $request, $token)
    {
        try {
            $result = $this->userService->linkSent($request->all(), $token);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => __('user.send_link_fail')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return redirect()->to($result);
    }
}
