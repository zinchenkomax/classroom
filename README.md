Тестовое задание Classroom API
==============================

Задача
------
```url
https://gist.github.com/ingvar/b014fd94c0ca383cee75f4be478b68c8
```

Результат
---------
Результат представлен готового проекта, кторый может быть развернут.
Проект реализован на базе фреймворка Symfony 4.
Для работы с базой данных используется ORM Doctrine 2.
Прект представляет только серверную часть и предполагает 
использование отдельного фронтедн проекта для своего использования.

Все точки доступа к АПИ размещены в одном контроллере: ClassroomController
В контроллере применяется автоматическое разрешение зависимотей (Autowiring) 
для получения экремпляров классов EntityManager и Validator.

Методы некоторых точек доступа используют автоматическую загрузку записей из   
базы данных с помощью Doctrine Converter, встроенного конвертера параметров 
(@ParamConverter) в бандл SensioFrameworkExtraBundle.

Создание базы данных и таблицы выполнено с помощью консольных команд
`doctrine:database:create`
`make:entity`
 
Это позволило создать миграции базы данных. Миграции могут 
быть использованы для развертывания проекта.

Установка:
----------
* Клонируйте репозиторий
```bash
$ git clone https://github.com/zinchenkomax/classroom.git
```

* Установите зависимоти
```bash
$ cd classroom
$ composer install
```

* Настройте подключение к серверу баз данных. Для этого оттредактируйте файл `.env`
в корне проекта.

* Создайте базу данных
```bash
$ php bin/console doctrine:database:create
```

* Мигрируйте  
```bash
$ php bin/console doctrine:migrations:migrate
```

* Настройте веб-сервер. Для ознакомительных целей достаточно встроенного 
веб-сервера для разработки. 
```bash
$ symfony serve
```
 
* Используйте АПИ.

Описание методов АПИ
--------------------
а) Список классов. Запрос
```bash
$ curl http://localhost:8000/classrooms
```

Ответ
```json
{
    "data": [
        {
            "id": 1,
            "name": "English Class",
            "createdAt": {"date":"2019-09-26 23:02:03.000000","timezone_type":3,"timezone":"Europe\/Kiev"},
            "isActive": true
        },
        {
            "id": 2,
            "name": "Math Class",
            "createdAt": {"date":"2019-09-26 23:06:11.000000","timezone_type":3,"timezone":"Europe\/Kiev"},
            "isActive": true
        },
        {
            "id": 3,
            "name": "Biology Class2",
            "createdAt": {"date":"2019-09-26 23:06:42.000000","timezone_type":3,"timezone":"Europe\/Kiev"},
            "isActive": true
        }
    ],
    "total":3
}
```

б) Один класс. Запрос
```bash
$ curl http://localhost:8000/classroom/1
```
Ответ
```json
{
    "id": 1,
    "name": "English Class",
    "createdAt": {"date":"2019-09-26 23:02:03.000000","timezone_type":3,"timezone":"Europe\/Kiev"},
    "isActive": true
}
```

в) Создать класс. Запрос
```bash
curl -X POST \
  http://127.0.0.1:8000/classroom \
  -H 'Content-Type: application/json' \
  -H 'Postman-Token: 368ae9ba-a8b9-461d-90cb-96c2420a8651' \
  -H 'cache-control: no-cache' \
  -d '{
        "name": "Biology Class",
        "isActive": true
    }'
```
Ответ
```json
{
    "id": 4,
    "name": "Biology Class4",
    "createdAt": {
        "date": "2019-09-27 22:46:19.618614",
        "timezone_type": 3,
        "timezone": "Europe/Kiev"
    },
    "isActive": true
}
```

г) Изменить класс
```bash
curl -X PUT \
  http://127.0.0.1:8000/classroom/3 \
  -H 'Content-Type: application/json' \
  -d '{"name":"Biology Class2"}'
```

д) Удалить класс. Запрос
```bash
curl -X DELETE http://127.0.0.1:8000/classroom/4 
```
Ответ
```json
{
    "message": "Classroom deleted: Biology Class4"
}
```

е) Изменить статус класса. Запрос
```bash
curl -X PUT \
  http://127.0.0.1:8000/classroom/1 \
  -d '{
	"isActive": false
}'
```
Ответ
```json
{
    "id": 1,
    "name": "English Class",
    "createdAt": {
        "date": "2019-09-26 23:02:03.000000",
        "timezone_type": 3,
        "timezone": "Europe/Kiev"
    },
    "isActive": false
}
```
