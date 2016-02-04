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
		$message->setListId(14);
		$message->setFromAddress('mark@zayconfresh.com');
		//$message->setReplyToAddress(NULL);
		//$message->setBounceAddress(NULL);
		//$message->setSenderAddress(NULL);
		$message->setSendToAddress('marksimond.s@gmail.com');
		//$message->setCcToAddress(NULL);
		$message->setTemplateId(14);
		//$message->setBodyText('This is plain text.'); // This is usually defined in the template.
		//$message->setBodyHtml('<h2>This is a test</h2>'); // This is usually defined in the template.
		//$message->setSubject('Test from API'); // This is usually defined in the template.
		$message->setFormat(99);
		//$message->setCampaignName(NULL);
		//$message->setVirtualMta(NULL);
		//$message->setDuplicate(FALSE);
		//$message->setIgnoreOptout(TRUE); // Set to TRUE if sending a transactional email, which ignores any opt out.
		//$message->setCharacterEncoding(NULL); // This is usually defined in the template.
		$message->setData('customLastname,customSalutation^Simonds,Mister');

		$output = $whatcounts->subscribeAndSendOneOffMessage($message);
		var_dump($output);
	}
	catch ( ZayconWhatCounts\Exception $e )
	{
		var_dump( $e );
	}