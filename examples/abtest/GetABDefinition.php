<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:46 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$ab_definition = new ZayconWhatCounts\ABTest();
		$ab_definition->setId(4);

		$whatcounts->getABDefinition($ab_definition);

		if (class_exists('Kint')) {
			!Kint::dump($ab_definition);
		} else {
			var_dump($ab_definition);
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