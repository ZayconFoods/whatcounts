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

    $lists = $whatcounts->showLists();
	if (class_exists('Kint')) {
		Kint::dump($lists);
	} else {
		var_dump($lists);
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