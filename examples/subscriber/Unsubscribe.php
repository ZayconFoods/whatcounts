<?php
    /**
     * Created by PhpStorm.
     * User: marksimonds
     * Date: 1/29/16
     * Time: 1:38 PM
     */

    require_once('../config.php');

    try
    {
        /* initialize whatcounts */
        $whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

	    $subscriber = new ZayconWhatCounts\Subscriber;
	    $subscriber->setFirstName("Joe");
	    $subscriber->setLastName("Smith");
	    $subscriber->setEmail("joe@example.com");
	    $subscriber->setListId(10);

        $unsubscriber = $whatcounts->unsubscribe($subscriber, $subscriber->getListId(), FALSE);
	    if (class_exists('Kint')) {
		    Kint::dump($unsubscriber);
	    } else {
		    var_dump($unsubscriber);
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