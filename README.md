Laravel 8.80

php artisan migrate --seed

В сидерах создание роли администратора и пользователя с такой ролью (todo) 

php artisan fake

Генерация тестовых данных (роли, пользователи и др.). У всех пользователей пароль password У тестового администратора email admin@admin.ru У пользователя user@user.ru сгенерирован bearer-токен для авторизации 2|Vdl7CeO6oAn5jmkpdkWYvxyLQSBfjxJTkAK6nS1i 

php artisan storage:link

Для загрузки файлов

php artisan permission:cache-reset

Если внесены изменения в роли и разрешения в обход пакета spatie/laravel-permission, то необходимо сбросить кеш

php artisan scribe:generate

Генерация документации

Документация API находится в папке public/docs и доступна по ссылке /docs