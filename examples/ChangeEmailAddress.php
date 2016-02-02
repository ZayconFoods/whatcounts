<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/1/16
	 * Time: 4:10 PM
	 */

	require_once( 'config.php' );

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$subscriber_id = 142975;
		$subscriber = $whatcounts->showSubscriber($subscriber_id);

		$whatcounts->changeEmailAddress($subscriber, "marksimondsupdated@gmail.com");
		var_dump($subscriber);
	}
	catch ( ZayconWhatCounts\Exception $e )
	{
		var_dump( $e );
	}