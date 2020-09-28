<?php

require_once("PayPal-PHP-SDK/autoload.php");
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AW-kskrKJ3F1HOrbvxWLyDqdUn5nxIpE0GAPhxZ6ShvfOD25RaD2MGompC8N81OpJ9XKOgm9VLtBtuz1',     // ClientID
        'ECAtWNJ_5dlNlDuyj7K86gg_9p36b5RzaLDiJHEjvMxNkroBYHHGV5fB0JKj7xGqFx3sw2aC1Q2BnzjB'      // ClientSecret
    )
);
?>