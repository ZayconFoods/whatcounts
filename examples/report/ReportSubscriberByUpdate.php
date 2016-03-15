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
		$start_datetime = '2/1/2016 12:00:00';
		$end_datetime = '4/1/2016 11:59:59';

		$output = $whatcounts->reportSubscriberByUpdate($list_id, $start_datetime, $end_datetime);
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