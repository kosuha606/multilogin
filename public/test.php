<?php

use app\client\Login;

require_once __DIR__.'/../vendor/autoload.php';

$login = new Login('kosuha606', 'AAASSSZZZQ@@!123123');
$token = $login->getToken();

$profile = [];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $profile = $login->getProfileData($id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="/js/multilogin.js"></script>
</head>
<body>
<h1>Test login</h1>

<a href="/test.php">Сбросить</a>
<pre id="result"><?php print_r($profile) ?></pre>

<hr>

<button onclick="openWindow('Vkontakte')">
    VK
</button>
<button onclick="openWindow('Facebook')">
    FB
</button>
<button onclick="openWindow('Google')">
    G+
</button>
<button onclick="openWindow('Odnoklassniki')">
    OK
</button>

<p>&nbsp;</p>
<h1>Test mobile login</h1>

<hr>

<button onclick="openWindowMobile('Vkontakte')">
    VK
</button>
<button onclick="openWindowMobile('Facebook')">
    FB
</button>
<button onclick="openWindowMobile('Google')">
    G+
</button>
<button onclick="openWindowMobile('Odnoklassniki')">
    OK
</button>

<p>&nbsp;</p>


    <script>
        Multilogin.onSuccess = function(token) {
            location.href = location.pathname+'?id='+token;
        };

        function openWindow(provider) {
            var url = 'https://multilogin.kosuha606.ru/login/'+provider+'?token=<?= $token ?>';

            Multilogin.doLogin(url);
        }

        function openWindowMobile(provider) {
            var url = 'https://multilogin.kosuha606.ru/login/'+provider+'?token=<?= $token ?>';

            Multilogin.doLogin(url, 'https://multilogin.kosuha606.ru/test.php');
        }

        Multilogin.init();
    </script>
</body>
</html>