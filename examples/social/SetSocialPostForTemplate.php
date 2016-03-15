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

		$template = new ZayconWhatCounts\Template();
		$template->setTemplateId(14);


		$social_provider = new ZayconWhatCounts\SocialProvider();
		$social_provider->setProviderName('twitter');


		$social_post = new ZayconWhatCounts\SocialPost();
		$social_post->setPost('This is a post created from the API.');


		$output = $whatcounts->setSocialPostForTemplate($template, $social_provider, $social_post);
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