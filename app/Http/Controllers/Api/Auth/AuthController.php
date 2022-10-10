<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\CustomValidationException;
use App\Http\Resources\Profile\ProfileResource;
use App\Http\Resources\Roles\PermissionResource;
use App\Http\Resources\Roles\SimpleRoleResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
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
                'password' => 'required|string',
            ]
        );
    }

    /**
     * Вход
     *
     * Аккаунт пользователя должен быть активным (is_active равно 1)
     *
     * @bodyParam email string required
     * @bodyParam password string required
     *
     * @unauthenticated
     * @group Пользователь
     *
     * @response scenario=success {
     *  "success": true,
     *  "user": {
     *      "id": 2,
     *      "name": "Иван",
     *      "surname": "Сидоров",
     *      "middle_name": "Петрович",
     *      "phone": "+7 (922) 489-0478",
     *      ...
     *  },
     *  "api_token": "2|Vdl7CeO6oAn5jmkpdkWYvxyLQSBfjxJTkAK6nS1i"
     * }
     *
     * @response status=401 scenario="invalid password" {
     *  "success": false
     *  "message": "Неправильный логин или пароль",
     * }
     *
     * @response status=401 scenario="user is not active" {
     *  "success": false
     *  "message": "Личный кабинет заблокирован администратором",
     * }
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws CustomValidationException
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            throw new CustomValidationException(
                'Неправильный логин или пароль', Response::HTTP_UNAUTHORIZED
            );
        }

        $user = User::where('email', $validator->validated()['email'])->first();

        if (!$user || !Hash::check($validator->validated()['password'], $user->password)) {
            throw new CustomValidationException(
                'Неправильный логин или пароль', Response::HTTP_UNAUTHORIZED
            );
        }

        if (!$user->is_active) {
            throw new CustomValidationException(
                'Личный кабинет заблокирован администратором', Response::HTTP_UNAUTHORIZED
            );
        }

        $user->tokens()->delete();

        $apiToken = $user->createToken('api_token')->plainTextToken;

        $user->update(['login_at' => now()]);

        return response_json(
            [
                'user' => ProfileResource::make($user),
                'api_token' => $apiToken
            ]
        );
    }

    /**
     * Получение текущего пользователя
     *
     * Получение основных данных, информации про отдел, роли, права роли.
     *
     * У пользователя есть роль. У роли есть права. Например, у роли `manager` есть право `crud roles`.
     *
     * @group Пользователь
     *
     * @response scenario=success {
     * "success": true,
     * "user": {
     *      "id": 2,
     *      "name": "Иван",
     *      "surname": "Сидоров",
     *      "middle_name": "Петрович",
     *      "phone": "+7 (922) 489-0478",
     *      "born_at": "11.09.1971",
     *      "office_position": "numquam",
     *      "about": "Molestiae facilis harum occaecati non aut quis aut magni.",
     *      "email": "user@user.ru",
     *      "is_active": true,
     *      "is_about_visible": true,
     *      "is_born_at_visible": false,
     *      "login_at": "16.01.2022",
     *      "avatar": null,
     *      "department": {
     *          "id": 3,
     *          "name": "veritatis / eum",
     *          "slug": "id-sed-aut-molestias-modi-natus-est-nequ"
     *      },
     *      "roles": [
     *          {
     *              "id": 3,
     *              "name": "manager",
     *              "title": "Менеджер"
     *          }
     *      ],
     *      "permissions": [
     *          {
     *              "name": "crud roles",
     *              "title": "Доступны все действия над ролями"
     *          },
     *          {
     *              "name": "cud users",
     *              "title": "Создание, редактирование и удаление сотрудников"
     *          }
     *      ]
     *    }
     * }
     *
     * @return JsonResponse
     */
    public function getUser(): JsonResponse
    {
        return response_json(['user' => ProfileResource::make(user())]);
    }

    /**
     * Получение прав
     *
     * Получение списка прав и списка ролей текущего пользователя
     *
     * @group Пользователь
     *
     * @return JsonResponse
     */
    public function getUserPermissions(): JsonResponse
    {
        return response_json(
            [
                'permissions' => PermissionResource::collection(user()->getPermissionsViaRoles()),
                'roles' => SimpleRoleResource::collection(user()->roles)
            ]
        );
    }

    /**
     * Выход
     *
     * Удаление всех токенов текущего пользователя
     *
     * @group Пользователь
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response_success();
    }
}
