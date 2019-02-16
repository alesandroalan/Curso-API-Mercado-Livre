<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=100%, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Curso API Mercado Livre</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css"
          integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"
            integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp"
            crossorigin="anonymous"></script>
</head>
<body>
<?php
session_start();

require 'lib/Meli/meli.php';
require 'configApp.php';
$meli = new Meli($appId, $secretKey);

if (isset($_GET['code']) || isset($_SESSION['access_token'])) {

    // If code exist and session is empty
    if (isset($_GET['code']) && !isset($_SESSION['access_token'])) {
        // //If the code was in get parameter we authorize
        try {
            $user = $meli->authorize($_GET["code"], $redirectURI);

            // Now we create the sessions with the authenticated user
            $_SESSION['access_token'] = $user['body']->access_token;
            $_SESSION['expires_in'] = time() + $user['body']->expires_in;
            $_SESSION['refresh_token'] = $user['body']->refresh_token;
        } catch (Exception $e) {
            echo "Exception: ", $e->getMessage(), "\n";
        }
    } else {
        // We can check if the access token in invalid checking the time
        if ($_SESSION['expires_in'] < time()) {
            try {
                // Make the refresh proccess
                $refresh = $meli->refreshAccessToken();

                // Now we create the sessions with the new parameters
                $_SESSION['access_token'] = $refresh['body']->access_token;
                $_SESSION['expires_in'] = time() + $refresh['body']->expires_in;
                $_SESSION['refresh_token'] = $refresh['body']->refresh_token;
            } catch (Exception $e) {
                echo "Exception: ", $e->getMessage(), "\n";
            }
        }
    }
    header('Location: home.php');
} else {
    echo '<div class="container text-center" style="padding-top: 20%;">';
    echo '<a class="btn btn-primary"  href="' . $meli->getAuthUrl($redirectURI, Meli::$AUTH_URL[$siteId])
        . '">Autorizar APP usando MercadoLivre oAuth 2.0</a>';
    echo '</div>';
}
?>
</body>
</html>

