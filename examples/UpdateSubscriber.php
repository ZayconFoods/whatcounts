<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/1/16
	 * Time: 3:47 PM
	 */

	require_once( 'config.php' );

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$subscriber_id = 92969;
		$subscriber = $whatcounts->showSubscriber($subscriber_id);
		//var_dump($subscriber);

		$subscriber_lists = $subscriber->getLists();

		$subscriber->setListId($subscriber_lists[0]->getListId());
		$subscriber->setLastName("SimondsUpdatedAgainAndAgain");

		$updated_subscriber = $whatcounts->updateSubscriber($subscriber);
		var_dump($updated_subscriber);
	}
	catch ( ZayconWhatCounts\Exception $e )
	{
		var_dump( $e );
	}