<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:55 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$campaign = new ZayconWhatCounts\Campaign();
		$campaign
			->setListId(23)
			->setTemplateId(35)
			->setSubject('Test Campagin')
			->setSeedListId(0)
			->setSegmentationId(0)
			->setFormat(99)
			->setAlias('')
			->setRss(0)
			->setVmta('zaycon1')
			->setAbDefinitionId(0)
			->setDeployedByEmail('')
			->setReturnTaskId(1)
			->setSeedDelivery(0)
			->setSendNotification('mark@zayconfresh.com');

		$output = $whatcounts->launchCampaign($campaign);
		if (class_exists('Kint')) {
			Kint::dump($output);
		} else {
			var_dump($output);
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