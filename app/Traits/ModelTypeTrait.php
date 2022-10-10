<?php

namespace App\Traits;

use App\Exceptions\CustomValidationException;

trait ModelTypeTrait
{
    /**
     * @return array
     */
    public static function getModelMapAliases(): array
    {
        return array_keys(self::getModelMap());
    }

    /**
     * @return array
     */
    public static function getModelMapClasses(): array
    {
        return array_values(self::getModelMap());
    }

    /**
     * @param  string  $alias
     * @param  int  $id
     * @return mixed
     * @throws CustomValidationException
     */
    public static function getModel(string $alias, int $id): mixed
    {
        return app(self::getModelClass($alias))::findOrFail($id);
    }

    /**
     * @param  string  $alias
     * @return string
     * @throws CustomValidationException
     */
    public static function getModelClass(string $alias): string
    {
        if (!in_array($alias, self::getModelMapAliases(), true)) {
            throw new CustomValidationException('Недопустимое название сущности: '.$alias);
        }

        return self::getModelMap()[$alias] ?? '';
    }

    /**
     * @param  string|null  $class
     * @return string
     */
    public static function getModelAlias(?string $class): string
    {
        return array_flip(self::getModelMap())[$class] ?? '';
    }
}
