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
        $subscriber->setFirstName("Mark");
        $subscriber->setLastName("Simonds3");
        $subscriber->setEmail("marksimond.s@gmail.com");
        $subscriber->setListId(12);

        $unsubscriber = $whatcounts->unsubscribe($subscriber, $subscriber->getListId(), FALSE);
        var_dump($unsubscriber);
    }
    catch ( ZayconWhatCounts\Exception $e )
    {
        var_dump( $e );
    }