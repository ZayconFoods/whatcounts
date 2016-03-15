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
			->setTemplateId(35)
			->setFolderId(0)
			->setName("Another Test Template")
			->setSubject("Another Test from WhatCounts (updated)")
			->setBodyPlain("(updated) Hello %%set salutation = \$customSalutation%%%%\$salutation%% %%set last_name = \$customLastname%%%%\$last_name%%!")
			->setBodyHtml("<html><head><title></title></head><body><h2>(updated) Hello %%set salutation = \$customSalutation%%%%\$salutation%% %%set last_name = \$customLastname%%%%\$last_name%%!</h2></body></html>")
			->setDescription("This is the description (updated)");

		$output = $whatcounts->updateTemplate($template);
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