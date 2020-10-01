<?php

/** @var string $data */

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logged in</title>
</head>
<body onload="sendDataToCaller()">
Авторизация...
<script>
    data = <?= $data ?>;

    function sendDataToCaller() {
        if (window.opener) {
            window.opener.postMessage(data, '*');
            window.close();
        } else {
            if (data.redirect) {
                location.href=data.redirect+'?multilogin_token='+data.id;
            }
        }
    }
</script>
</body>
</html>
