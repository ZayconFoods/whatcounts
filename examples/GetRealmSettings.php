<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 1/22/16
 * Time: 9:19 AM
 */

require_once( 'config.php' );

try
{
	/* initialize whatcounts */
	$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

	$realm = $whatcounts->getRealmSettings();
	var_dump($realm);
}
catch ( ZayconWhatCounts\Exception $e )
{
	var_dump( $e );
}