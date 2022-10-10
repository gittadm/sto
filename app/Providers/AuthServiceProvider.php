<?php

namespace App\Providers;

use App\Models\RoleConst;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(
            function ($user, $ability) {
                return $user->is_admin ? true : null;
            }
        );

        Gate::define(
            'users-crud',
            function (User $user) {
                return $user->hasPermissionTo(RoleConst::PERMISSION_USERS_CRUD);
            }
        );

        Gate::define(
            'users-read',
            function (User $user) {
                return $user->hasPermissionTo(RoleConst::PERMISSION_USERS_READ);
            }
        );

        Gate::define(
            'clients-crud',
            function (User $user) {
                return $user->hasPermissionTo(RoleConst::PERMISSION_CLIENTS_CRUD);
            }
        );

        Gate::define(
            'clients-read',
            function (User $user) {
                return $user->hasPermissionTo(RoleConst::PERMISSION_CLIENTS_READ);
            }
        );

        Gate::define(
            'pipelines-crud',
            function (User $user) {
                return $user->hasPermissionTo(RoleConst::PERMISSION_PIPELINES_CRUD);
            }
        );

        $this->registerCommentGates();

        $this->registerTaskGates();
    }

    private function registerCommentGates(): void
    {
        Gate::define(
            'read-task-comments',
            function (User $user, $model) {
                return $user->hasPermissionTo(RoleConst::PERMISSION_TASKS_READ) ||
                    ($user->hasPermissionTo(RoleConst::PERMISSION_TASKS_READ_DEPARTMENT) &&
                        $user->department_id === $model->department_id) ||
                    ($user->hasPermissionTo(RoleConst::PERMISSION_TASKS_READ_OWN) &&
                        ($user->id === $model->user_id || $user->id === $model->author_id));
            }
        );

        Gate::define(
            'read-comments',
            function (User $user, string $modelAlias, $model) {
                if ($modelAlias === 'task') {
                    return Gate::check('read-task-comments', [$model]);
                }
                return false;
            }
        );

        Gate::define(
            'store-comments',
            function (User $user, string $modelAlias, $model) {
                if ($modelAlias === 'task') {
                    return Gate::check('read-task-comments', [$model]);
                }
                return false;
            }
        );
    }

    private function registerTaskGates(): void
    {
        Gate::define(
            'read-tasks',
            function (User $user) {
                return $user->hasPermissionTo(RoleConst::PERMISSION_TASKS_READ);
            }
        );

        Gate::define(
            'read-department-tasks',
            function (User $user, ?int $departmentId = null) {
                return Gate::check('read-tasks') ||
                    ($user->hasPermissionTo(RoleConst::PERMISSION_TASKS_READ_DEPARTMENT) &&
                        (is_null($departmentId) || $user->department_id === $departmentId));
            }
        );

        Gate::define(
            'read-own-tasks',
            function (User $user, $task = null) {
                return Gate::check('read-tasks') ||
                    Gate::check('read-department-tasks', [$task->department_id ?? null]) ||
                    ($user->hasPermissionTo(RoleConst::PERMISSION_TASKS_READ_OWN) &&
                        (empty($task) || $user->id === $task->user_id || $user->id === $task->author_id));
            }
        );

        Gate::define(
            'create-tasks',
            function (User $user) {
                return $user->hasPermissionTo(RoleConst::PERMISSION_TASKS_CREATE);
            }
        );

        Gate::define(
            'update-tasks',
            function (User $user) {
                return $user->hasPermissionTo(RoleConst::PERMISSION_TASKS_UPDATE);
            }
        );

        Gate::define(
            'update-department-tasks',
            function (User $user, ?int $departmentId = null) {
                return Gate::check('update-tasks') ||
                    ($user->hasPermissionTo(RoleConst::PERMISSION_TASKS_UPDATE_DEPARTMENT) &&
                        (is_null($departmentId) || $user->department_id === $departmentId));
            }
        );

        Gate::define(
            'update-own-tasks',
            function (User $user, $task = null) {
                return Gate::check('update-tasks') ||
                    Gate::check('update-department-tasks', [$task->department_id ?? null]) ||
                    ($user->hasPermissionTo(RoleConst::PERMISSION_TASKS_UPDATE_OWN) &&
                        (empty($task) || $user->id === $task->user_id || $user->id === $task->author_id));
            }
        );

        Gate::define(
            'delete-tasks',
            function (User $user) {
                return $user->hasPermissionTo(RoleConst::PERMISSION_TASKS_DELETE);
            }
        );

        Gate::define(
            'delete-department-tasks',
            function (User $user, ?int $departmentId = null) {
                return Gate::check('delete-tasks') ||
                    ($user->hasPermissionTo(RoleConst::PERMISSION_TASKS_DELETE_DEPARTMENT) &&
                        (is_null($departmentId) || $user->department_id === $departmentId));
            }
        );

        Gate::define(
            'delete-own-tasks',
            function (User $user, $task = null) {
                return Gate::check('delete-tasks') ||
                    Gate::check('delete-department-tasks', [$task->department_id ?? null]) ||
                    ($user->hasPermissionTo(RoleConst::PERMISSION_TASKS_DELETE_OWN) &&
                        (empty($task) || $user->id === $task->user_id || $user->id === $task->author_id));
            }
        );
    }
}
