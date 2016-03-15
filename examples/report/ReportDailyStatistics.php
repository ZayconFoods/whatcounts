<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:57 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$campaign_id = 47;
		$start_date = '2/1/2016';
		$end_date = '4/1/2016';

		$output = $whatcounts->reportDailyStatistics($campaign_id, $start_date, $end_date);
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