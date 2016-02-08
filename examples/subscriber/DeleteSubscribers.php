<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/2/16
	 * Time: 8:26 AM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$subscriber_emails = [
			'marc.freeman@example.com',
			'amelia.lowe@example.com'
		];

		$deleted_subscribers = $whatcounts->deleteSubscribers($subscriber_emails);
		if (class_exists('Kint')) {
			Kint::dump($deleted_subscribers);
		} else {
			var_dump($deleted_subscribers);
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