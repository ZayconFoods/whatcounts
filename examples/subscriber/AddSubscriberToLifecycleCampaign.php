<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/1/16
	 * Time: 4:18 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$campaign_name = "test_automation_campaign";

		$subscriber_id = 123456;
		$subscriber = $whatcounts->showSubscriber($subscriber_id);

		$updated_subscriber = $whatcounts->addSubscriberToLifecycleCampaign($subscriber, $campaign_name);
		if (class_exists('Kint')) {
			Kint::dump($updated_subscriber);
		} else {
			var_dump($updated_subscriber);
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