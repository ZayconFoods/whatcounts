<?php
    /**
     * Created by PhpStorm.
     * User: marksimonds
     * Date: 1/25/16
     * Time: 4:13 PM
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
        $subscriber->setAddress1("1234 Main St");
        $subscriber->setAddress2("Suite 100");
        $subscriber->setCity("Spokane");
        $subscriber->setState("WA");
        $subscriber->setZip("99201");
        $subscriber->setCountry("US");
        $subscriber->setPhone("5095551212");
        $subscriber->setFax("5095551213");
        $subscriber->setCompany("Zaycon");
        $subscriber->setForceSub(false);
        $subscriber->setFormat(99);
        $subscriber->setOverrideConfirmation(false);
        $subscriber->setListId(10);

        $subscribers = $whatcounts->subscribe($subscriber);
        if (class_exists('Kint')) {
            Kint::dump($updated_subscriber);
        } else {
            var_dump($updated_subscriber);
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