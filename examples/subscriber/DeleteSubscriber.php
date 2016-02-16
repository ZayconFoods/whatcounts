<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/2/16
	 * Time: 8:25 AM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$subscriber_id = 123456;
		$subscriber = $whatcounts->showSubscriber($subscriber_id);

		$deleted_subscriber = $whatcounts->deleteSubscriber($subscriber);
		if (class_exists('Kint')) {
			Kint::dump($deleted_subscriber);
		} else {
			var_dump($deleted_subscriber);
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