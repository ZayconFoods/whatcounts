<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 1/21/16
 * Time: 2:31 PM
 *
 * Copy to config.php and input your realm and password for testing
 */

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once('/path/to/guzzlehttp');
require_once('/path/to/parseCSV');
require_once( dirname( __DIR__ ) . '/src/whatcounts_required.php' );

define( 'WC_REALM', '[YOUR_REALM]');
define( 'WC_PASSWORD', '[YOUR_PASSWORD]' );

echo '<pre>';