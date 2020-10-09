MULTILOGIN
---

Сервис для авторизации через соцсети.

Этот файл https://github.com/kosuha606/multilogin/blob/master/config/providers.php.dist
нужно переименовать в providers.php
И заполнить по инструкции
https://hybridauth.github.io/introduction.html


Этот файл необходим для учета пользователей, которые могут использовать сервис
https://github.com/kosuha606/multilogin/blob/master/config/users.php.dist

Этот класс клиента
https://github.com/kosuha606/multilogin/blob/master/src/client/Login.php

Можно скопировать в код приложения, подставить параметры
- baseUrl
- password
- user

И иcпользовать API класса для работы с сервисом авторизации.

Со стороны клинетской части можно использовать этот скрипт.
https://github.com/kosuha606/multilogin/blob/master/public/js/multilogin.js

Пример работы можно найти здесь:
https://multilogin.kosuha606.ru/test.php
