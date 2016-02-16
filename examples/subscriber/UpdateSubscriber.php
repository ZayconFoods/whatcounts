<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/1/16
	 * Time: 3:47 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$subscriber_id = 123456;
		$subscriber = $whatcounts->showSubscriber($subscriber_id);

		$subscriber_lists = $subscriber->getLists();

		$subscriber->setListId($subscriber_lists[0]->getListId());
		$subscriber->setLastName("Smith Jr.");

		$updated_subscriber = $whatcounts->updateSubscriber($subscriber);
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