<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/1/16
	 * Time: 4:10 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$subscriber_id = 123456;
		$subscriber = $whatcounts->showSubscriber($subscriber_id);

		$whatcounts->changeEmailAddress($subscriber, "joejr@example.com");
		if (class_exists('Kint')) {
			Kint::dump($subscriber);
		} else {
			var_dump($subscriber);
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