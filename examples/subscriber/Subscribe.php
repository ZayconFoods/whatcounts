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
    $subscriber->setFirstName("Mark");
    $subscriber->setLastName("Simonds3");
    $subscriber->setEmail("marksimond.s@gmail.com");
    $subscriber->setAddress1("1234 Main St");
    $subscriber->setAddress2("Ste 100");
    $subscriber->setCity("Spokane");
    $subscriber->setState("WA");
    $subscriber->setZip("99201");
    $subscriber->setCountry("US");
    $subscriber->setPhone("5092306321");
    $subscriber->setFax("5095551212");
    $subscriber->setCompany("Zaycon");
    $subscriber->setForceSub(false);
    $subscriber->setFormat(99);
    $subscriber->setOverrideConfirmation(false);
    $subscriber->setListId(12);

    $subscribers = $whatcounts->subscribe($subscriber);
    var_dump($subscribers);
}
catch ( ZayconWhatCounts\Exception $e )
{
    var_dump( $e );
}