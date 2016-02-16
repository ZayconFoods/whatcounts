# ZayconWhatCounts

[![Latest Stable Version](https://poser.pugx.org/zaycon/whatcounts/v/stable)](https://packagist.org/packages/zaycon/whatcounts)
[![Total Downloads](https://poser.pugx.org/zaycon/whatcounts/downloads)](https://packagist.org/packages/zaycon/whatcounts)
[![Build Status](https://travis-ci.org/ZayconFoods/whatcounts.svg?branch=master)](https://travis-ci.org/ZayconFoods/whatcounts)
[![Coverage Status](https://coveralls.io/repos/ZayconFoods/whatcounts/badge.svg?branch=master&service=github)](https://coveralls.io/github/ZayconFoods/whatcounts?branch=master)

PHP API Wrapper for the WhatCounts HTTP API (https://support.whatcounts.com/hc/en-us/categories/200372375-API-HTTP)

## Table of Contents
* [Installation](#install)
* [Documentation](#documentation)
* [Todo](#todo)
* [About](#about)

----
## <a name="install"></a>Installation

Add ZayconWhatCounts to your `composer.json` file. If you are not using [Composer](http://getcomposer.org), you should be. It's an excellent way to manage dependencies in your PHP application.

```json
{
  "require": {
    "zaycon/whatcounts": "1.0.*"
  }
}
```

----
## <a name="documentation"></a>Documentation

### Initialize Your Object

```php
$whatcounts = new ZayconWhatCounts\WhatCounts( [YOUR_API_REALM], [YOUR_API_PASSWORD] );
```

###Realms

####Get Realm Settings
```php
$realm = $whatcounts->getRealmSettings();
```

###Lists

####Show Lists

```php
$lists = $whatcounts->showLists();
```

####Get List by ID

```php
$list_id = 10;
$list = $whatcounts->getListById($list_id);
```

####Get List by Name

```php
$list_name = "Marketing List";
$list = $whatcounts->getListByName($list_name);
```

####Create List

```php
$list = new ZayconWhatCounts\MailingList;
$list
	->setListName('API Test');
	->setDescription('This is a test list');
	->setFromAddress('from@example.com');
	->setReplyToAddress('reply-to@example.com');
	->setBounceAddress('bounce@example.com');
	->setTrackClicks(true);
	->setTrackOpens(true);

$new_list = $whatcounts->createList($list);
```

####Update List

```php
$list_id = 10;
$list = $whatcounts->showList($list_id);
$list->setListName('API Test');

$updated_list = $whatcounts->updateList($list);
```


###Subscriber Management
####Find Subscriber

```php
$subscriber = new ZayconWhatCounts\Subscriber;
$subscriber
	->setFirstName("Joe");
	->setLastName("Smith");

$subscribers = $whatcounts->findSubscribers($subscriber);
```

####Find Subscriber in List

```php
$list_id = 10;

$subscriber = new ZayconWhatCounts\Subscriber;
$subscriber
	->setFirstName("Joe");
	->setLastName("Smith");
	->setEmail("joe@example.com");

$subscribers = $whatcounts->findSubscriberInList($subscriber, $list_id, TRUE);
```

####Subscribe

```php
$subscriber = new ZayconWhatCounts\Subscriber;
$subscriber
	->setFirstName("Joe");
	->setLastName("Smith");
	->setEmail("joe@example.com");
	->setAddress1("1234 Main St");
	->setAddress2("Suite 100");
	->setCity("Spokane");
	->setState("WA");
	->setZip("99201");
	->setCountry("US");
	->setPhone("5095551212");
	->setFax("5095551213");
	->setCompany("Zaycon");
	->setForceSub(false);
	->setFormat(99);
	->setOverrideConfirmation(false);
	->setListId(10);

$subscribers = $whatcounts->subscribe($subscriber);
```

####Unsubscribe

```php
$subscriber = new ZayconWhatCounts\Subscriber;
$subscriber
	->setFirstName("Joe");
	->setLastName("Smith");
	->setEmail("joe@example.com");
	->setListId(10);

$unsubscriber = $whatcounts->unsubscribe($subscriber, $subscriber->getListId(), FALSE);
```

####Delete Subscriber

```php
$subscriber_id = 123456;
$subscriber = $whatcounts->showSubscriber($subscriber_id);

$deleted_subscriber = $whatcounts->deleteSubscriber($subscriber);
```

####Delete Subscribers

```php
$subscriber_emails = [
	'marc.freeman@example.com',
	'amelia.lowe@example.com'
];

$deleted_subscribers = $whatcounts->deleteSubscribers($subscriber_emails);
```

####Show Subscriber Details

```php
$subscriber_id = 123456;
$subscriber = $whatcounts->showSubscriber($subscriber_id);
```

####Update Subscriber

```php
$subscriber_id = 123456;
$subscriber = $whatcounts->showSubscriber($subscriber_id);

$subscriber_lists = $subscriber->getLists();

$subscriber
	->setListId($subscriber_lists[0]->getListId());
	->setLastName("Smith Jr.");

$updated_subscriber = $whatcounts->updateSubscriber($subscriber);
```

####Change Email Address

```php
$subscriber_id = 123456;
$subscriber = $whatcounts->showSubscriber($subscriber_id);
$whatcounts->changeEmailAddress($subscriber, "joejr@example.com");
```

####Add Subscriber to Lifecycle Campaign

```php
$campaign_name = "test_automation_campaign";
		
$subscriber_id = 123456;
$subscriber = $whatcounts->showSubscriber($subscriber_id);

$updated_subscriber = $whatcounts->addSubscriberToLifecycleCampaign($subscriber, $campaign_name);
```


###Send Mail
####Send One-Off Message

```php
$message = new \ZayconWhatCounts\Mail();
$message
	->setListId(10);
	->setFromAddress('marketing@example.com');
	->setReplyToAddress('reply-to@example.com');
	->setBounceAddress('bounce@example.com');
	->setSenderAddress(NULL);
	->setSendToAddress('joe@example.com');
	->setCcToAddress('others@example.com');
	->setTemplateId(3);
	->setBodyText('This is plain text.'); // This is usually defined in the template.
	->setBodyHtml('<h2>This is a test</h2>'); // This is usually defined in the template.
	->setSubject('Test from API'); // This is usually defined in the template.
	->setFormat(99);
	->setCampaignName(NULL);
	->setVirtualMta(NULL);
	->setDuplicate(FALSE);
	->setIgnoreOptout(TRUE); // Set to TRUE if sending a transactional email, which ignores any opt out.
	->setCharacterEncoding(NULL); // This is usually defined in the template.
	->setData('customLastname,customSalutation^Smith,Mr');

$output = $whatcounts->sendOneOffMessage($message);
```

####Subscribe and Send One-Off Message

```php
$message = new \ZayconWhatCounts\Mail();
$message
	->setListId(10);
	->setFromAddress('marketing@example.com');
	->setReplyToAddress('reply-to@example.com');
	->setBounceAddress('bounce@example.com');
	->setSenderAddress(NULL);
	->setSendToAddress('joe@example.com');
	->setCcToAddress('others@example.com');
	->setTemplateId(3);
	->setBodyText('This is plain text.'); // This is usually defined in the template.
	->setBodyHtml('<h2>This is a test</h2>'); // This is usually defined in the template.
	->setSubject('Test from API'); // This is usually defined in the template.
	->setFormat(99);
	->setCampaignName(NULL);
	->setVirtualMta(NULL);
	->setDuplicate(FALSE);
	->setIgnoreOptout(TRUE); // Set to TRUE if sending a transactional email, which ignores any opt out.
	->setCharacterEncoding(NULL); // This is usually defined in the template.
	->setData('customLastname,customSalutation^Smith,Mr');

$output = $whatcounts->subscribeAndSendOneOffMessage($message);
```


###Reporting
####Show User Events

```php
$subscriber = $whatcounts->showSubscriber(123456);

$output = $whatcounts->showUserEvents($subscriber);
```

####Report Subscriber Events

```php
$subscriber = $whatcounts->showSubscriber(123456);

$output = $whatcounts->reportSubscriberEvents($subscriber);
```

####Report Unsubscribes

```php
$list_id = 10;
$output = $whatcounts->reportUnsubscribes($list_id);
```

####Show Optouts

```php
$list_id = 10;
$days = 30;

$output = $whatcounts->showOptouts($list_id, $days);
```

####Show Global Optouts

```php
$days = 30;

$output = $whatcounts->showGlobalOptouts($days);
```



----
## <a name="todo"></a>@todo


####A/B Testing
- showABDefinitions: Show A/B Definitions
- getABDefinition: Get A/B Definition
- reportABTestStatistics: Report A/B Test Statistics
- chooseABWinner: Choose A/B Winner

####Articles
- showArticles: Show Articles
- getArticleById: Get Article by ID
- getArticleByName: Get Article by Name
- copyArticle: Copy Article
- createBlankArticle: Create Article Blank
- createArticle: Create Article
- updateArticle: Update Article
- deleteArticle: Delete Article

####Folders
- createFolder: Create Folder
- getFolderById: Get Folder ID

####Templates
- showTemplates: Show Templates
- getTemplateById: Get Template by ID
- getTemplateByName: Get Template by Name
- createTemplate: Create Template
- updateTemplate: Update Template
- previewTemplate: Preview Template

####Segmentation Rules
- showSegmentationRules: Show Segmentation Rules
- createSegmentationRule: Create Segmentation Rule
- updateSegmentationRule: Update Segmentation Rule
- deleteSegmentationRule: Delete Segmentation Rule
- testSegmentationRule: Test Segmentation Rule

####Social
- getSocialProviders: Get All Social Providers
- getSocialProviderById: Get Social Provider by ID
- getSocialProviderByUserName: Get Social Provider by Username
- deleteSocialProviderById: Delete Social Provider by ID
- deleteSocialProviderByUserName: Delete Social Provider by Username
- setSocialPostForTemplate: Set Social Post for Template
- getSocialPostsByTemplateId: Get Social Posts by Template ID
- getSocialPostsByTemplateName: Get Social Posts by Template Name

####Send Mail
- launchCampaign: Launch Campaign
- scheduleCampaignt: Schedule Campaign Deployment
- processSpringbotAbandonedCart: Process Abandoned Cart

####Relational Data

No API documentation exists for these commands (https://support.whatcounts.com/hc/en-us/articles/204669685-Commands)

- relationalactivatefield: Activate Field
- relationalactivatetable: Activate Table
- relationaladdfield: Add Field
- relationaladdtable: Add Table
- relationaldelete: Delete Data
- relationalfind: Find Data
- relationalfindfield: Find Field
- relationalfindtables: Find Table
- relationalsave: Save Data

####Reporting
- showCampaigns: Show Campaigns
- reportCampaignList: Report Campaign List
- showCampaignStatistics: Show Campaign Statistics
- showMultipleCampaginStatistics: Show Multiple Campaign Statistics
- reportCampaignClicks: Report Campaign Clicks
- reportSubscriberClicks: Report Subscriber Clicks
- reportDailyStatistics: Report Daily Statistics
- reportBrowserInfo: Report Browser Info
- reportBounceStatistics: Report Bounce Statistics
- reportTrackedEvents: Report Tracked Events
- reportTrackedEventsByCampaign: Report Tracked Events by Campaign
- showHardBounces: Show Hard Bounces
- showSoftBounces: Show Soft Bounces
- showBlockBounces: Show Block Bounces
- showComplaints: Show Complaints
- reportSubscriberByUpdate: Report Subscriber by Update
- reportSubscribersInList: Report Subscribers in List


###API Issues

These commands do not return well formed XML:

- showLists
- showSegmentationRules
- showTemplates
- showArticles
- showUserEvents

These commands do not properly return a FAILURE (when test returns no results):

- findinlist
- find

Using API version 8.4.0 causes command 'detail' to return incomplete XML

Executing command subandsend sends email and adds subscriber but doesn't seem to add to a list.

----
## <a name="about"></a>About
Developed by [Zaycon Fresh](https://www.zayconfresh.com)


