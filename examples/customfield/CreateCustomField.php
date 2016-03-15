<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:47 PM
	 */

	require_once('../config.php');

	define('FIELD_TYPE_NUMBER', 0);
	define('FIELD_TYPE_TEXT', 1);
	define('FIELD_TYPE_DATE', 2);
	define('FIELD_TYPE_LARGETEXT', 3);
	define('FIELD_TYPE_UNICODETEXT', 6);
	define('FIELD_TYPE_FLOAT', 7);

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$custom_field = new ZayconWhatCounts\Field();
		$custom_field
			->setName('custom-number')
			->setDescription('This is a number field')
			->setType(FIELD_TYPE_NUMBER);

		$output = $whatcounts->createCustomField($custom_field);
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