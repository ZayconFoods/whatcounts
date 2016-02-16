<?php
/**
 * Created by PhpStorm.
 * User: marksimonds
 * Date: 1/26/16
 * Time: 10:10 AM
 */

require_once('../config.php');

try
{
    /* initialize whatcounts */
    $whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

	$list_id = 10;
    $list = $whatcounts->showList($list_id);
    $list->setListName('API Test (another update)');

    $updated_list = $whatcounts->updateList($list);
	if (class_exists('Kint')) {
		Kint::dump($updated_list);
	} else {
		var_dump($updated_list);
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