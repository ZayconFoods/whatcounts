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

	$list_name = "Marketing List";
	$list = $whatcounts->getListByName($list_name);
	if (class_exists('Kint')) {
		Kint::dump($list);
	} else {
		var_dump($list);
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