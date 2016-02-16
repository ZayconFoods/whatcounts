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

	    $subscriber_id = 123456;
	    $subscriber = $whatcounts->showSubscriber($subscriber_id);
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