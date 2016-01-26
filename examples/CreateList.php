<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/26/16
 * Time: 9:46 AM
 */

require_once( 'config.php' );

try
{
    /* initialize whatcounts */
    $whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

    $list = new ZayconWhatCounts\MailingList;

    $list->setListName('API Test');
    $list->setDescription('This is a test list');
    $list->setFromAddress('mark@zayconfresh.com');
    $list->setReplyToAddress('tony@zayconfresh.com');
    $list->setBounceAddress('ethan@zayconfresh.com');
    $list->setTrackClicks(true);
    $list->setTrackOpens(true);

    $new_list = $whatcounts->createList($list);
    var_dump($new_list);
}
catch ( ZayconWhatCounts\Exception $e )
{
    var_dump( $e );
}