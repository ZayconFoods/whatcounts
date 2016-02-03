<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/25/16
 * Time: 4:13 PM
 */

require_once('../config.php');

try
{
    /* initialize whatcounts */
    $whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

    $subscriber_id = 142975;

    $subscriber = $whatcounts->showSubscriber($subscriber_id);
    var_dump($subscriber);
}
catch ( ZayconWhatCounts\Exception $e )
{
    var_dump( $e );
}