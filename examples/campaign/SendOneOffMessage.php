<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 2/3/16
	 * Time: 2:55 PM
	 */

	require_once('../config.php');

	try
	{
		/* initialize whatcounts */
		$whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

		$message = new \ZayconWhatCounts\Mail();
		$message->setListId(10);
		$message->setFromAddress('marketing@example.com');
		$message->setReplyToAddress('reply-to@example.com');
		$message->setBounceAddress('bounce@example.com');
		$message->setSenderAddress(NULL);
		$message->setSendToAddress('joe@example.com');
		$message->setCcToAddress('others@example.com');
		$message->setTemplateId(3);
		$message->setBodyText('This is plain text.'); // This is usually defined in the template.
		$message->setBodyHtml('<h2>This is a test</h2>'); // This is usually defined in the template.
		$message->setSubject('Test from API'); // This is usually defined in the template.
		$message->setFormat(99);
		$message->setCampaignName(NULL);
		$message->setVirtualMta(NULL);
		$message->setDuplicate(FALSE);
		$message->setIgnoreOptout(TRUE); // Set to TRUE if sending a transactional email, which ignores any opt out.
		$message->setCharacterEncoding(NULL); // This is usually defined in the template.
		$message->setData('customLastname,customSalutation^Smith,Mr');

		$output = $whatcounts->sendOneOffMessage($message);
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