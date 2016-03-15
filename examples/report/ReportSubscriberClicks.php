<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:56 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$campaign_id = 47;
		$url = 'https://www.zayconfresh.com/products/beef/fresh-937-lean-ground-beef';
		$is_exact = FALSE;
		$is_unique = FALSE;

		$output = $whatcounts->reportSubscriberClicks($campaign_id, $url, $is_exact, $is_unique);
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