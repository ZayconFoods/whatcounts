<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:56 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$campaign_statistics = new ZayconWhatCounts\Report();
		$campaign_statistics->setCampaignId(43);

		$whatcounts->showCampaignStatistics($campaign_statistics);
		if (class_exists('Kint')) {
			!Kint::dump($campaign_statistics);
		} else {
			var_dump($campaign_statistics);
		}
	}
	catch ( ZayconWhatCounts\Exception $e )
	{
		if (class_exists('Kint')) {
			!Kint::dump($e);
		} else {
			var_dump($e);
		}
	}