<?php
/**
 * Global Variables
 */

/** Check server domain for type of dev environment */
if ( isset($_SERVER) && isset($_SERVER['SERVER_NAME']) ):
    $_ENV['DEV_MODE'] = !(strpos($_SERVER['SERVER_NAME'], 'production-domain.org') !== false);
    $_ENV['LOCAL_DEV_MODE'] = (strpos($_SERVER['SERVER_NAME'], '.dev') !== false);
else:
    $_ENV['DEV_MODE'] = false;
    $_ENV['LOCAL_DEV_MODE'] = false;
endif;

$DEV_MODE = $_ENV['DEV_MODE'];

/** Debug tools */
$GLOBALS['user_log_file'] = ABSPATH . '/user.log';

/** Global WP property overrides */
$GLOBALS['title_override'] = '';
$GLOBALS['excerpt_override'] = '';
