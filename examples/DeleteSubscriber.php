<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/2/16
	 * Time: 8:25 AM
	 */

	require_once( 'config.php' );

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$subscriber_id = 142975;
		$subscriber = $whatcounts->showSubscriber($subscriber_id);

		$deleted_subscriber = $whatcounts->deleteSubscriber($subscriber);
		var_dump($deleted_subscriber);
	}
	catch ( ZayconWhatCounts\Exception $e )
	{
		var_dump( $e );
	}