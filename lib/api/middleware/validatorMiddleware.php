<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/core/utils.php';

function checkLogUserParams() {
    if (
        !isset( $_GET )
        || !isset( $_GET[ 'userId' ] )
        || !is_string( $_GET[ 'userId' ] )
        || empty( $_GET[ 'userId' ] )
    ) {
        return error400( "INVALID USER_ID" );
    }

    return true;
}

function checkRefreshTokenParams() {

    if (
        !isset( $_GET )
        || !isset( $_GET[ 'userId' ] )
        || !is_string( $_GET[ 'userId' ] )
        || empty( $_GET[ 'userId' ] )
    ) {
        return error400( "INVALID USER_ID" );
    }

    if (
        !isset( $_GET )
        || !isset( $_GET[ 'sessionId' ] )
        || !is_string( $_GET[ 'sessionId' ] )
        || empty( $_GET[ 'sessionId' ] )
    ) {
        return error400( "INVALID SESSION_ID" );
    }

    return true;
}

?>
