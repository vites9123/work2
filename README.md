# REST API для работы с пользователями

Этот REST API предоставляет методы для управления пользователями: создание, обновление, удаление, аутентификация и получение информации о пользователе. Для хранения данных используется файл `users.json`.

## Методы

### Создание пользователя

**Метод:** `POST`  
**Endpoint:** `/users.php`

**Пример запроса с помощью Curl:**
curl -X POST -F "id=1" -F "username=user1" -F "password=password1" -F "email=user1@example.com" http://test.ru/users.php


### Авторизация пользователя
**Метод:** `POST`
**Endpoint:** `/login.php`

**Пример запроса с помощью Curl:**
curl -X POST -d "{\"username\": \"user1\", \"password\": \"password1\"}" http://test.ru/login.php


### Обновление информации о пользователе

**Метод:** `PUT`  
**Endpoint:** `/users.php?id={userId}`

**Пример запроса с помощью Curl:**
curl -X PUT -d "email=newemail@example.com" "http://test.ru/users.php?id=1"



### Удаление пользователя

**Метод:** `DELETE`  
**Endpoint:** `/users.php?id={userId}`

**Пример запроса с помощью Curl:**
curl -X DELETE "http://test.ru/users.php?id=1"



### Получить информацию о пользователе

**Метод:** `GET`  
**Endpoint:** `/users.php?id={userId}`

**Пример запроса с помощью Curl:**
curl "http://test.ru/users.php?id=1"



## Примечания

- Замените `http://test.ru` на фактический адрес вашего сервера.
