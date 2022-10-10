<?php

namespace App\Http\Controllers\Api\Roles;

use App\Http\Controllers\Controller;
use App\Models\RoleConst;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_ROLES_CRUD]);
    }

    /**
     * Список прав
     *
     * Права: `crud roles`
     *
     * @group Роли
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response_json(['permissions' => RoleConst::getPermissionsWithTitles()]);
    }
}
