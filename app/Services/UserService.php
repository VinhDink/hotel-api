<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Store user
     *
     * @param  object  $data
     * @return bool
     */
    public function store($data)
    {
        $this->userRepository->store([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'role' => $data['role'],
        ]);

        return true;
    }

    /**
     * Get all user
     *
     * @return object
     */
    public function index()
    {
        $result = $this->userRepository->index();

        return $result;
    }

    /**
     * Destroy user
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
        $result = $this->userRepository->destroy($id);

        return $result;
    }

    /**
     * Verify user email
     *
     * @param  object  $data
     * @return bool
     */
    public function verifyEmail($data, $id, $hash)
    {
        $hashedEmail = sha1($this->userRepository->find($id)->email);
        $userRole = $this->userRepository->find($id)->role;

        if ($hashedEmail == $hash) {
            $this->userRepository->update($id, ['email_verified_at' => now()]);
            if ($userRole == 'admin' || $userRole == 'employee') {
                return env('ADMIN_URL') . '/verify-email';
            }
            if ($userRole == 'guest') {
                return env('CUSTOMER_URL') . '/verify-email';
            }
        } else {
            return false;
        }
    }

    /**
     * Reset user password
     *
     * @param  object  $data
     * @return bool
     */
    public function resetPassword($data)
    {
        $status = Password::sendResetLink(
            $data
        );

        return $status;
    }

    /**
     * Set new password
     *
     * @param  object  $data
     * @return bool
     */
    public function setNewPassword($data)
    {
        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                info($password);
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? true
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Send link to reset password
     *
     * @param  string  $email, $token
     * @return bool
     */
    public function linkSent($email, $token)
    {
        $userRole = $this->userRepository->findByEmail($email['email'])->role;

        if ($userRole == 'guest') {
            return env('CUSTOMER_URL') . '/reset-password/' . $token;
        } else {
            return env('ADMIN_URL') . '/reset-password/' . $token;
        }
    }
}
