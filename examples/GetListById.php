<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/25/16
 * Time: 4:13 PM
 */

require_once( 'config.php' );

try
{
    /* initialize whatcounts */
    $whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

    $list = $whatcounts->getListById(5);
    var_dump($list);
}
catch ( ZayconWhatCounts\Exception $e )
{
    var_dump( $e );
}