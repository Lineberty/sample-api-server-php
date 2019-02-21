<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/core/apiLinebertyHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/core/utils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/api/middleware/validatorMiddleware.php';

$apiLinebertyHandler = new ApiLinebertyHandler();

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

    try {
        $resApi = $apiLinebertyHandler->createUser();
        return200( $resApi );

    } catch ( Exception $e ) {
        error500( $e );
    }

} else {
   error404();
}

?>
