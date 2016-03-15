<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 3/14/16
	 * Time: 11:51 AM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$list_id = 13;
		$offset = 0;

		$output = $whatcounts->reportSubscribersInList($list_id, $offset);
		if (class_exists('Kint')) {
			!Kint::dump($output);
		} else {
			var_dump($output);
		}
	}
	catch ( ZayconWhatCounts\Exception $e )
	{
		if (class_exists('Kint')) {
			!Kint::dump($e);
		} else {
			var_dump($e);
		}
	}