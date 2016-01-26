<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/26/16
 * Time: 10:10 AM
 */

require_once( 'config.php' );

try
{
    /* initialize whatcounts */
    $whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

    $list = $whatcounts->showList(10);

    $list->setListName('API Test (another update)');

    $updated_list = $whatcounts->updateList($list);
    var_dump($updated_list);
}
catch ( ZayconWhatCounts\Exception $e )
{
    var_dump( $e );
}