<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/1/16
	 * Time: 4:18 PM
	 */

	require_once( 'config.php' );

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$subscriber_id = 142971;
		$subscriber = $whatcounts->showSubscriber($subscriber_id);

		$updated_subscriber = $whatcounts->addSubscriberToLifecycleCampaign($subscriber, 'test_automation_campaign');
		var_dump($updated_subscriber);
	}
	catch ( ZayconWhatCounts\Exception $e )
	{
		var_dump( $e );
	}