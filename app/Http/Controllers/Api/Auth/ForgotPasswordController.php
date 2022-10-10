<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\CustomValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    protected function validator(array $data
    ): \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator {
        return Validator::make(
            $data,
            [
                'email' => 'required|string|email',
            ]
        );
    }

    /**
     * Email для сброса пароля
     *
     * Отправка ссылки для сброса пароля на email.
     *
     * Пример ссылки: http://127.0.0.1:8000/password/reset/8dcac035833f2b09a862cad429e078ae78b94e69be798d19624aca9ce177a176?email=user%40user.ru
     *
     * @group Пользователь
     *
     * @unauthenticated
     *
     * @bodyParam email string required
     *
     * @response scenario=success {
     *   "success": true,
     *   "message": "Ссылка на сброс пароля была отправлена"
     * }
     *
     * @param  Request  $request
     * @return JsonResponse|void
     * @throws ValidationException
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            throw new CustomValidationException(
                'Недопустимый email', Response::HTTP_UNAUTHORIZED
            );
        }

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        if ($response == Password::RESET_LINK_SENT) {
            return new JsonResponse(['success' => true, 'message' => trans($response)], 200);
        }

        throw ValidationException::withMessages(
            [
                'email' => [trans($response)],
            ]
        );
    }
}
