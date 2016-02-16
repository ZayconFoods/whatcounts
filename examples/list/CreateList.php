<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/26/16
 * Time: 9:46 AM
 */

require_once('../config.php');

try
{
    /* initialize whatcounts */
    $whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

    $list = new ZayconWhatCounts\MailingList;
	$list->setListName('API Test');
	$list->setDescription('This is a test list');
	$list->setFromAddress('from@example.com');
	$list->setReplyToAddress('reply-to@example.com');
	$list->setBounceAddress('bounce@example.com');
	$list->setTrackClicks(true);
	$list->setTrackOpens(true);

    $new_list = $whatcounts->createList($list);
	if (class_exists('Kint')) {
		Kint::dump($new_list);
	} else {
		var_dump($new_list);
	}
}
catch ( ZayconWhatCounts\Exception $e )
{
    if (class_exists('Kint')) {
		Kint::dump($e);
	} else {
		var_dump($e);
	}
}