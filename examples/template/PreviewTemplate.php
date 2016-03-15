<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:27 PM
	 */

	require_once('../config.php');

	define('TEMPLATE_TYPE_PLAIN', 1);
	define('TEMPLATE_TYPE_HTML', 2);

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$template = new ZayconWhatCounts\Template;
		$template
			->setName("Another Test Template");

		$output = $whatcounts->previewTemplate($template, TEMPLATE_TYPE_HTML);
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