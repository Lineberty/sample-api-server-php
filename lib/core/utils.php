<?php

    function return200( $res ) {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        http_response_code(200);
        echo json_encode( $res );
        die();
    }

    function return204() {
        header('Access-Control-Allow-Headers: access-control-allow-methods,access-control-allow-origin,content-type');
        header('Access-Control-Allow-Methods: GET,HEAD,PUT,PATCH,POST,DELETE');
        header('Access-Control-Allow-Origin: *');
        header('Content-Length: 0');
        header('Vary: Access-Control-Request-Headers');
        http_response_code(204);
        die();
    }

    function error400( $msg ) {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        http_response_code(400);
        echo json_encode( array( "error" => $msg ) );
        die();
    }

    function error404() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        http_response_code(404);
        echo json_encode( array( "error" => "NOT_FOUND" ) );
        die();
    }

    function error500( $e ) {
        syslog( LOG_ERR, "500 internal error : " .  $e->getMessage() . "\n" );
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        http_response_code(500);
        echo json_encode( array( "error" => "INTERNAL_ERROR" ) );
        die();
    }

?>
