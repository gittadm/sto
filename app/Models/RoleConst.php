<?php

namespace App\Models;

use Illuminate\Support\Str;
use ReflectionClass;

class RoleConst
{
    public const GUARD_NAME = 'sanctum';

    public const ROLE_ADMIN = 'admin';

    public const PERMISSION_FINANCES_CRUD = 'crud finances';
    public const PERMISSION_STORAGES_CRUD = 'crud storages';
    public const PERMISSION_FUELS_CRUD = 'crud fuels';
    public const PERMISSION_ENGINE_VOLUMES_CRUD = 'crud engine volumes';
    public const PERMISSION_CAR_MARKS_CRUD = 'crud car marks';
    public const PERMISSION_CAR_MODELS_CRUD = 'crud car models';
    public const PERMISSION_CARS_CRUD = 'crud cars';
    public const PERMISSION_CITIES_CRUD = 'crud cities';
    public const PERMISSION_ROLES_CRUD = 'crud roles';
    public const PERMISSION_DEPARTMENTS_CRUD = 'crud departments';
    public const PERMISSION_DOCUMENT_TEMPLATES_CRUD = 'crud document templates';

    public const PERMISSION_TASKS_READ = 'read tasks';
    public const PERMISSION_TASKS_READ_DEPARTMENT = 'read department tasks';
    public const PERMISSION_TASKS_READ_OWN = 'read own tasks';
    public const PERMISSION_TASKS_CREATE = 'create tasks';
    public const PERMISSION_TASKS_UPDATE = 'update tasks';
    public const PERMISSION_TASKS_UPDATE_DEPARTMENT = 'update department tasks';
    public const PERMISSION_TASKS_UPDATE_OWN = 'update own tasks';
    public const PERMISSION_TASKS_DELETE = 'delete tasks';
    public const PERMISSION_TASKS_DELETE_DEPARTMENT = 'delete department tasks';
    public const PERMISSION_TASKS_DELETE_OWN = 'delete own tasks';

    public const PERMISSION_USERS_CRUD = 'crud users';
    public const PERMISSION_USERS_READ = 'read users';
    public const PERMISSION_CLIENTS_CRUD = 'crud clients';
    public const PERMISSION_CLIENTS_READ = 'read clients';
    public const PERMISSION_PIPELINES_CRUD = 'crud pipelines';
    public const PERMISSION_PROCESSES_CRUD = 'crud processes';

    /**
     * @return string[]
     */
    public static function getPermissions(): array
    {
        $constants = (new ReflectionClass(__CLASS__))->getConstants();

        $permissions = [];
        foreach ($constants as $key => $constant) {
            if (Str::startsWith($key, 'PERMISSION')) {
                $permissions[] = $constant;
            }
        }

        return $permissions;
    }

    /**
     * @return array[]
     */
    public static function getTaskPermissionsWithTitles(): array
    {
        return [
            [
                'title' => 'Задачи',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_TASKS_READ,
                        'title' => 'Просмотр всех задач'
                    ],
                    [
                        'id' => self::PERMISSION_TASKS_READ_DEPARTMENT,
                        'title' => 'Просмотр задач только своего отделения'
                    ],
                    [
                        'id' => self::PERMISSION_TASKS_READ_OWN,
                        'title' => 'Просмотр только своих задач'
                    ],
                    [
                        'id' => self::PERMISSION_TASKS_CREATE,
                        'title' => 'Создание задач'
                    ],
                    [
                        'id' => self::PERMISSION_TASKS_UPDATE,
                        'title' => 'Редактирование всех задач'
                    ],
                    [
                        'id' => self::PERMISSION_TASKS_UPDATE_DEPARTMENT,
                        'title' => 'Редактирование задач только своего отделения'
                    ],
                    [
                        'id' => self::PERMISSION_TASKS_UPDATE_OWN,
                        'title' => 'Редактирование только своих задач'
                    ],
                    [
                        'id' => self::PERMISSION_TASKS_DELETE,
                        'title' => 'Удаление любой задачи'
                    ],
                    [
                        'id' => self::PERMISSION_TASKS_DELETE_DEPARTMENT,
                        'title' => 'Удаление любой задачи своего отделения'
                    ],
                    [
                        'id' => self::PERMISSION_TASKS_DELETE_OWN,
                        'title' => 'Удаление любой своей задачи'
                    ],
                ]
            ],
        ];
    }

    /**
     * @return array[]
     */
    public static function getPermissionsWithTitles(): array
    {
        $permissions = [
            [
                'title' => 'Города',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_CITIES_CRUD,
                        'title' => 'Все действия над городами'
                    ],
                ]
            ],
            [
                'title' => 'Роли',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_ROLES_CRUD,
                        'title' => 'Все действия над ролями'
                    ],
                ]
            ],
            [
                'title' => 'Отделы',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_DEPARTMENTS_CRUD,
                        'title' => 'Все действия над отделами'
                    ],
                ]
            ],
            [
                'title' => 'Сотрудники',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_USERS_CRUD,
                        'title' => 'Все действия над сотрудниками'
                    ],
                    [
                        'id' => self::PERMISSION_USERS_READ,
                        'title' => 'Просмотр сотрудников'
                    ],
                ]
            ],
            [
                'title' => 'Автомобили',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_CARS_CRUD,
                        'title' => 'Все действия над автомобилями'
                    ],
                    [
                        'id' => self::PERMISSION_CAR_MARKS_CRUD,
                        'title' => 'Все действия над марками автомобилей'
                    ],
                    [
                        'id' => self::PERMISSION_FUELS_CRUD,
                        'title' => 'Все действия над видами топлива'
                    ],
                    [
                        'id' => self::PERMISSION_ENGINE_VOLUMES_CRUD,
                        'title' => 'Все действия над объемами двигателя'
                    ],
                    [
                        'id' => self::PERMISSION_CAR_MODELS_CRUD,
                        'title' => 'Все действия над моделями автомобилей'
                    ],
                ]
            ],
            [
                'title' => 'Клиенты',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_CLIENTS_CRUD,
                        'title' => 'Все действия над клиентами'
                    ],
                    [
                        'id' => self::PERMISSION_CLIENTS_READ,
                        'title' => 'Просмотр клиентов'
                    ],
                ]
            ],
            [
                'title' => 'Склад',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_STORAGES_CRUD,
                        'title' => 'Все действия со складом'
                    ],
                ]
            ],
            [
                'title' => 'Финансы',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_FINANCES_CRUD,
                        'title' => 'Все действия с финансами'
                    ],
                ]
            ],
            [
                'title' => 'Воронки',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_PIPELINES_CRUD,
                        'title' => 'Все действия с воронками и их этапами'
                    ],
                ]
            ],
            [
                'title' => 'Процессы',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_PROCESSES_CRUD,
                        'title' => 'Все действия с процессами'
                    ],
                ]
            ],
            [
                'title' => 'Документы',
                'permissions' => [
                    [
                        'id' => self::PERMISSION_DOCUMENT_TEMPLATES_CRUD,
                        'title' => 'Все действия с шаблонами документов'
                    ],
                ]
            ],
        ];

        return array_merge($permissions, self::getTaskPermissionsWithTitles());
    }

    /**
     * @param  string  $id
     * @return string|null
     */
    public static function getTitleById(string $id): ?string
    {
        $permissions = self::getPermissionsWithTitles();

        foreach ($permissions as $permission) {
            foreach ($permission['permissions'] as $value) {
                if ($value['id'] === $id) {
                    return $value['title'];
                }
            }
        }

        return null;
    }
}
