<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:06 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$segmentation_rule = new ZayconWhatCounts\SegmentationRule();
		$segmentation_rule->setId(7);
		$segmentation_rule->setListId(14);
		$segmentation_rule->setName('Test Segmentation Rule (updated)');
		$segmentation_rule->setDescription('This is a test segmentation rule.');
		$segmentation_rule->setType('adv');
		$segmentation_rule->setRules("email='user@example.com'");

		$output = $whatcounts->updateSegmentationRule($segmentation_rule);
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