<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:49 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$social_provider = new ZayconWhatCounts\SocialProvider();
		$social_provider->setProviderId(522);

		$whatcounts->getSocialProviderById($social_provider);

		if (class_exists('Kint')) {
			!Kint::dump($social_provider);
		} else {
			var_dump($social_provider);
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