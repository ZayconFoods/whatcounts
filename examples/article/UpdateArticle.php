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

		$article = new ZayconWhatCounts\Article();
		$article
			->setId(5)
			->setName('article-1')
			->setTitle('Test Article Title')
			->setDescription('Test Article Description')
			->setDeck('This is the actual article deck.')
			->setCallout('Test Article Callout')
			->setBody('Test Article Body')
			->setAuthorName('Mark Simonds')
			->setAuthorBio('This is the bio for Mark Simonds')
			->setAuthorEmail('mark@zayconfresh.com')
			->setFolderId(0);

		$is_updated = $whatcounts->updateArticle($article);
		if (class_exists('Kint')) {
			Kint::dump($is_updated);
		} else {
			var_dump($is_updated);
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