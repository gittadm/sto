<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\CustomValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    protected function validator(array $data
    ): \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator {
        return Validator::make(
            $data,
            $this->rules()
        );
    }

    /**
     * Обновление пароля
     *
     * @group Пользователь
     *
     * @unauthenticated
     *
     * @bodyParam token string required
     * @bodyParam email string required
     * @bodyParam password string required Пароль должен содержать не менее 8 символов
     *
     * @response scenario=success {
     *   "success": true,
     *   "message": "Ваш пароль был сброшен",
     * }
     *
     * @response status=422 {
     *   "success": false,
     *   "message": "Ошибочный код сброса пароля",
     * }
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function reset(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            throw new CustomValidationException(
                implode(" ", $validator->errors()->all()), Response::HTTP_UNAUTHORIZED
            );
        }

        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return new JsonResponse(['success' => true, 'message' => trans($response)], 200);
        }

        throw ValidationException::withMessages(
            [
                'email' => [trans($response)],
            ]
        );
    }

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
    }

    /**
     *  @unauthenticated
     *
     * Fake method for using route 'password.reset' in email
     *
     * @param  Request  $request
     * @return string
     */
    public function showResetForm(Request $request)
    {
        return 'redirect to frontend';
    }
}
