<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:31 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$output = $whatcounts->createArticle($article);
		var_dump($output);
	}
	catch ( ZayconWhatCounts\Exception $e )
	{
		var_dump( $e );
	}