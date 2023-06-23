# tamtem-agents система

Система регистрации организаций по реферальным ссылкам и полуения пассивного дохода

## Конфигурация

В .env задать константу TAMTEM_URL = здесь прописать урл(хоста) нашего основного сервера,
куда будут идти по реферальной ссылке, иначе ссылка будет генериться согласно
конфигу constants.tamtem.url , там сейчас что-то типа : 'url' => env('TAMTEM_URL', 'https://tamtem.ru')

## Установка

git clone https://github.com/ArtemGkovalev/TamTem_agent.git

mcedit .env #Check options for Database, Redis, EMAIL,
composer install
sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap/cache
php artisan migrate:refresh --seed
php artisan key:generate

Убедитесь в правильности установки и в том что верно настроили среду для проекта.

Панель администратора доступна по адресу http://localhost/admin, `l: admin@admin.com, p: admin`

## Запуск периодических заданий

Запускаем крон для периодических заданий, каждую полночь будут запускаться
crontab -e
@midnight php /... path_to_the_artisan ... /artisan schedule:run >> /dev/null 2>&1

**Релиз нового кода:**

-   php artisan down
-   Забрать код из гита
-   composer install
-   composer dump-autoload
-   php artisan migrate
-   php artisan cache:clear
-   php artisan config:cache
-   php artisan up

-   остановить echo-server и воркеры очереди
-   php artisan down
-   Забрать код из гита
-   composer install
-   composer dump-autoload
-   php artisan migrate
-   php artisan cache:clear
-   php artisan config:cache
-   php artisan up
-   запустить echo-server и воркеры очереди

# frontend - инструкции

## Настройка проекта

## Переход к модулям frontend-части

```
cd frontend
```

```
Все npm-команды запускать из папки `frontend`
```

### Установка/обновление списка зависимостей

```
npm install
```

### Сборка и hot-reloads запуск для разработки

```
npm run serve
```

### Сборка и минификация для production

```
npm run build
```

### Run your tests

```
npm run test
```

### Lints and fixes files

```
npm run lint
```

### Customize configuration

See [Configuration Reference](https://cli.vuejs.org/config/).

# API tamtem-agents

### Авторизация

    [POST] /api/v1/login

| Field      | Req |
| ---------- | --- |
| `password` | y   |
| `email`    | y   |

Возвращает `api_token`, который используется для запросов требующих авторизацию.
Указывается либо как `GET` параметр `?api_token=you-api-token`, либо в заголовке `Authorization: Bearer you-api-token`.

### Регистрация пользователя

    [POST] /api/v1/register

| Field      | Req |
| ---------- | --- |
| `name`     | y   |
| `email`    | y   |
| `password` | y   |
| `phone`    | n   |
| `agent_id` | n   | = unique_id агента |

### Послать повторно письмо с подтверждением почты

    [POST] /api/v1/repeateregistermail

| Field   | Req |
| ------- | --- |
| `email` | y   |

### Сброс пароля, если забыл, новый приходит на почту

    [POST] /api/v1/passwordreset

| Field   | Req |
| ------- | --- |
| `email` | y   |

### Изменение пароля

    [Authorized]
    [POST] /api/v1/passwordchange

| Field                   | Req |
| ----------------------- | --- |
| `password_old`          | y   |
| `password`              | y   |
| `password_confirmation` | y   |

### Логин

    [POST] /api/v1/login

| Field      | Req |
| ---------- | --- |
| `email`    | y   |
| `password` | y   |

Возвращает `api_token`, который используется для запросов требующих авторизацию.
Указывается либо как `GET` параметр `?api_token=you-api-token`, либо в заголовке `Authorization: Bearer you-api-token`.

### Логаут

    [Authorized]
    [POST] /api/v1/logout

### Пользователи

#### Получить список пользователей (только с правами администратора)

    [Authorized]
    [GET] /api/v1/users

#### Получить пользователя по его id (только с правами администратора или владельца профиля)

    [Authorized]
    [GET] /api/v1/users/:id

#### Создать пользователя (только с правами администратора)

    [Authorized]
    [POST] /api/v1/users/store

| Field          | Req |
| -------------- | --- |
| `email`        | y   |
| `password`     | y   |
| `status`       | n   |
| `role`         | n   |
| `phone`        | n   |
| `photo`        | n   |
| `privilege_id` | n   |
| `points`       | n   |
| `ballance`     | n   |

#### Редактировать пользователя по его id (только с правами администратора или владельца профиля)

    [Authorized]
    [POST] /api/v1/users/:id

| Field          | Req |
| -------------- | --- |
| `email`        | n   |
| `password`     | n   |
| `status`       | n   |
| `role`         | n   |
| `phone`        | n   |
| `photo`        | n   |
| `privilege_id` | n   |
| `points`       | n   |
| `ballance`     | n   |

#### Удалить пользователя по его id (только с правами администратора)

    [Authorized]
    [DELETE] /api/v1/users/:id

#### Удалить аватарку пользователя по ссылке на файл по его id (только с правами администратора или владельца профиля)

    [Authorized]
    [POST] /api/v1/users/image/delete

| Field   | Req |
| ------- | --- |
| `photo` | n   | путь к файлу |

### Клиенты сайта (пользователи web портала)

#### Получить профиль (свой по token)

    [Authorized]
    [GET] /api/v1/user/profile

Если нет ошибок, возвращает JSON вида:
{
"result": true,
"data": {
"id": 3,
"name": "ivan",
"email": "ivan@mail.ru",
"unique_id": 7732046,
"status": 1,
"role": 1,
"phone": null,
"photo": null,
"privilege": {
"id": 2,
"name": "Бронзовый",
"procent": 10,
"duration_months": 12
},
"points": 650,
"ballance": 21.2
}
}

| Field                          | Descr                                   |
| ------------------------------ | --------------------------------------- |
| `id`                           | id                                      |
| `name`                         | имя                                     |
| `email`                        | email                                   |
| `unique_id`                    | уникальнй id                            | (по нему берется статистика с тамтема) |
| `status`                       | статус                                  | 0 - зарегистрирован, 1 - активный, -1 - забанен, -2 - удален |
| `role`                         | роль                                    | = id привилегии |
| `phone`                        | телефон                                 |
| `photo`                        | путь к фото                             |
| `points`                       | обзщее кол-во баллов                    |
| `ballance`                     | общий балланс , руб.                    |
| ------------------------------ | --------------------------------------- |
| `privilege`                    | структура по привилегиям (роли юзера)   |
| `privilege.id`                 | id привилегии (роли)                    |
| `privilege.name`               | название привилегии (роли)              |
| `privilege.procent`            | %, который дает привилегия (роль)       |
| `privilege.duration_months`    | количество месяцев действия привилегии  |

### Организации (компании)

#### Получить список своих компаний

    [Authorized]
    [GET] /api/v1/organizations

### Общая клиентская часть сайта

#### Проверить, доступно ли сгенерировать ссылку по указанному inn

    [Authorized]
    [POST] /api/v1/user/innisavailable

| Field | Req |
| ----- | --- |
| `inn` | y   |

Возвращает:
{"result":false} - не доступно, или
{"result":true} - доступно

#### Сгенерировать реферальную ссылку

    [Authorized]
    [POST] /api/v1/user/refgenerate

| Field  | Req |
| ------ | --- |
| `inn`  | y   |
| `name` | y   | название организации |
| `bid`  | n   | id сделки, которую заодно хотим показать юзеру после регистрации |

Возвращает:
{"result":false} - не доступно, или
{"result":true, "data": ССЫЛКА}

#### Сгенерировать реферальную ссылку на самого агента, для регистрации других агентов

    [Authorized]
    [POST] /api/v1/user/refgenerateforme

Возвращает:
{"result":true, "data": ССЫЛКА}

### Тестирование гипотезы о сделках и контактах организаций с тамтема

#### Получить список сделок

    [Authorized]
    [GET] /api/v1/hypothesis/deals

Вернется информация по сделкам и в каждой из них будет еще поле `organizations_count`. Если = 0 , то нет контактов организаций по сделке

#### Получить информацию по сделке по id сделки

    [Authorized]
    [GET] /api/v1/hypothesis/deals/:id

#### Получить информацию по прикрепленным к авторизованному агенту организациям по id сделки

    [Authorized]
    [GET] /api/v1/hypothesis/organizations/deal/:id

| Field      | Req | Description                                    |
| ---------- | --- | ---------------------------------------------- |
| `per_page` | n   | количество организаций на страницу (пагинация) |
| `page`     | n   | номер страницы (пагинация)                     |

#### Прикрепить организации (сейчас 15 штук) к авторизованному агенту по okved сделки

    [Authorized]
    [POST] /api/v1/hypothesis/organizations/attach

| Field   | Req | Description |
| ------- | --- | ----------- |
| `okved` | y   |             |

### Вывод денег c помощью Yandex

#### Вывод денег на карту

    [Authorized]
    [POST] /api/v1/yandex/initialpayoutpocard

| Field    | Req | Description                        |
| -------- | --- | ---------------------------------- |
| `amount` | y   | Не менее 100 руб. Пример: 185.45   |

Далее происходит редирект на страницу яндекса, где юзер вводит номер картыи все свои паспортные данные.
Если проверка прошла нормально , то яндекс редиректит к нам на страницу, на адрес (как пример):
http://tamtem-agents/api/v1/yandex/successbankcarddata/9659549/149.85?skr_destinationCardSynonim=HEr7SzpXIZV1UqPR53qJB3hD.SC.000.201912&skr_destinationCardType=Visa&skr_destinationCardCountryCode=643&skr_destinationCardPanmask=481776******8725&identificationStatus=success&accountNumber=4100110282315085
 
 Сервер получит все данные и попробует сделать запрос на зачисление на карту.

 После обработки произойдет редирект на ** '/?yandexpayout=true&msg=' **, где 
`yandexpayout` - успешное (true), или не успешное (false) зачисление на карту
`msg` - сообщение о успехе или суть ошибки

### Общая клиентская часть сайта

#### Проверить, доступно ли сгенерировать ссылку по указанному inn

    [Authorized]
    [POST] /api/v1/user/innisavailable

| Field | Req |
| ----- | --- |
| `inn` | y   |
