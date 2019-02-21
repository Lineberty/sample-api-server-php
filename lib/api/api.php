<?php

require $_SERVER['DOCUMENT_ROOT'] . '/lib/core/utils.php';

$url = $_SERVER["REQUEST_URI"];

if ( preg_match( '/^\/api\/v1\/lineberty\/(.+)$/', $url, $matches ) ) {

    $newUrl = $_SERVER['DOCUMENT_ROOT'] . "/lib/api/services/" . $matches[1] . ".php";

    if ( file_exists ( $newUrl ) ) {

        if ( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' ) {
            return204();
        } else {
            require $newUrl;
        }

    } else {
        error404();
    }

} else {
    syslog( LOG_INFO, "No match for URL " . $url . "\n" );
    error404();
}

?>
