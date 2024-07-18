# Сервис заметок

Сервис выполнен в стиле SPA (Single Page Application)

## Установка

Затяните репозиторий

```
git clone https://github.com/404maxy/notes.git
```

Соберите контейнеры

```
docker compose up -d --build
```

Обновите композер-зависимости

```
docker exec -it notes_php bash
cd notes
composer install
```

Инициализируйте проект для разработки (выберите версию Development)

```
php init
```

Настройте соединение с базой данных в файле www/notes/common/config/main-local.php

```
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=notes_mysql;dbname=notes',
            'username' => 'notes',
            'password' => 'n0t3sPwd',
            'charset' => 'utf8',
        ],
    ],
```

Запустите миграции (так же из контейнера notes_php)
```
php yii migrate
```

Откройте сайт по адресу http://localhost