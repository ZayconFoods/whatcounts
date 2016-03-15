<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:50 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$social_provider = new ZayconWhatCounts\SocialProvider();
		$social_provider
			->setUsername('Mark Simonds')
			->setProviderName('linkedin');

		$is_deleted = $whatcounts->deleteSocialProviderByUserName($social_provider);

		if (class_exists('Kint')) {
			!Kint::dump($is_deleted);
		} else {
			var_dump($output);
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