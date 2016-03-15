<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:27 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$template = new ZayconWhatCounts\Template;
		$template
			->setFolderId(0)
			->setName("Another Test Template")
			->setSubject("Another Test from WhatCounts")
			->setBodyPlain("Hello %%set salutation = \$customSalutation%%%%\$salutation%% %%set last_name = \$customLastname%%%%\$last_name%%!")
			->setBodyHtml("<html><head><title></title></head><body><h2>Hello %%set salutation = \$customSalutation%%%%\$salutation%% %%set last_name = \$customLastname%%%%\$last_name%%!</h2></body></html>")
			->setDescription("This is the description");

		$whatcounts->createTemplate($template);

		if (class_exists('Kint')) {
			Kint::dump($template);
		} else {
			var_dump($template);
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