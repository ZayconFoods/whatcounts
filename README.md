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

$is_updated = $whatcounts->updateList($list);
```


### Articles
#### Show Articles
```php
$articles = $whatcounts->showArticles();
```

#### Get Article by ID
```php
$article = new ZayconWhatCounts\Article();
$article->setId(5);

$whatcounts->getArticleById($article);
```

#### Get Article by Name
```php
$article = new ZayconWhatCounts\Article();
$article->setName('article-1');

$whatcounts->getArticleByName($article);
```

#### Copy Article
```php
$article_name = 'article-1';
$destination_article_name = 'article-1-copy';

$destination_article_id = $whatcounts->copyArticle($article_name, $destination_article_name);
```

#### Create Article Blank
```php
$article = new ZayconWhatCounts\Article();
$article
    ->setName('blank-test');

$whatcounts->createBlankArticle($article);
```

#### Create Article (not working)
```php
$article = new ZayconWhatCounts\Article();
$article
    ->setName('test')
    ->setTitle('Test Article Title')
    ->setDescription('Test Article Description')
    ->setDeck('This is the actual article deck.')
    ->setCallout('Test Article Callout')
    ->setBody('Test Article Body')
    ->setAuthorName('Joe Smith')
    ->setAuthorBio('This is the bio for Joe Smith')
    ->setAuthorEmail('joe@example.com')
    ->setFolderId(0);

$whatcounts->createArticle($article);
```

#### Update Article
```php
$article = new ZayconWhatCounts\Article();
$article
    ->setId(5)
    ->setName('article-1')
    ->setTitle('Test Article Title')
    ->setDescription('Test Article Description')
    ->setDeck('This is the actual article deck.')
    ->setCallout('Test Article Callout')
    ->setBody('Test Article Body')
    ->setAuthorName('Joe Smith')
    ->setAuthorBio('This is the bio for Joe Smith')
    ->setAuthorEmail('joe@example.com')
    ->setFolderId(0);

$is_updated = $whatcounts->updateArticle($article);
```

#### Delete Article
```php
$article_name = 'article-1-copy';

$is_deleted = $whatcounts->deleteArticle($article_name);
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

####Launch Campaign
```php
$campaign = new ZayconWhatCounts\Campaign();
$campaign
	->setListId(23)
	->setTemplateId(35)
	->setSubject('Test Campaign')
	->setSeedListId(0)
	->setSegmentationId(0)
	->setFormat(99)
	->setAlias('')
	->setRss(0)
	->setVmta('vmta1')
	->setAbDefinitionId(0)
	->setDeployedByEmail('')
	->setReturnTaskId(1)
	->setSeedDelivery(0)
	->setSendNotification('user@example.com');

$output = $whatcounts->launchCampaign($campaign);
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


###A/B Testing
####Show A/B Definitions

```php
$output = $whatcounts->showABDefinitions();
```

####Get A/B Definition

```php
$ab_definition = new ZayconWhatCounts\ABTest();
$ab_definition->setId(4);

$whatcounts->getABDefinition($ab_definition);
```

####Report A/B Test Statistics

```php
$ab_definition_id = 4;
$output = $whatcounts->reportABTestStatistics($ab_definition_id);
```

###Templates
####Show Templates

```php
$output = $whatcounts->showTemplates();
```

####Get Template by ID

```php
$template_id = 14;
$output = $whatcounts->getTemplateById($template_id);
```


####Get Template by Name

```php
$template_name = 'Test Template';
$output = $whatcounts->getTemplateByName();
```


####Create Template

```php
$template = new ZayconWhatCounts\Template;
$template
	->setFolderId(0)
	->setName("Another Test Template")
	->setSubject("Another Test from WhatCounts")
	->setBodyPlain("Hello %%set salutation = \$customSalutation%%%%\$salutation%% %%set last_name = \$customLastname%%%%\$last_name%%!")
	->setBodyHtml("<html><head><title></title></head><body><h2>Hello %%set salutation = \$customSalutation%%%%\$salutation%% %%set last_name = \$customLastname%%%%\$last_name%%!</h2></body></html>")
	->setDescription("This is the description");

$whatcounts->createTemplate($template);
```


####Update Template

```php
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
```


####Preview Template

```php
define('TEMPLATE_TYPE_PLAIN', 1);
define('TEMPLATE_TYPE_HTML', 2);
	
$template = new ZayconWhatCounts\Template;
$template
	->setName("Another Test Template");

$output = $whatcounts->previewTemplate($template, TEMPLATE_TYPE_HTML);
```

###Segmentation Rules
####Show Segmentation Rules
```php
$output = $whatcounts->showSegmentationRules();
```


####Create Segmentation Rule
```php
$segmentation_rule = new ZayconWhatCounts\SegmentationRule();
$segmentation_rule->setListId(14);
$segmentation_rule->setName('Test Segmentation Rule');
$segmentation_rule->setDescription('This is a test segmentation rule.');
$segmentation_rule->setType('adv');
$segmentation_rule->setRules("email='user@example.com'");

$output = $whatcounts->createSegmentationRule($segmentation_rule);
```


####Update Segmentation Rule
```php
$segmentation_rule = new ZayconWhatCounts\SegmentationRule();
$segmentation_rule->setId(7);
$segmentation_rule->setListId(14);
$segmentation_rule->setName('Test Segmentation Rule (updated)');
$segmentation_rule->setDescription('This is a test segmentation rule.');
$segmentation_rule->setType('adv');
$segmentation_rule->setRules("email='user@example.com'");

$output = $whatcounts->updateSegmentationRule($segmentation_rule);
```


####Delete Segmentation Rule
```php
$segmentation_rule = new ZayconWhatCounts\SegmentationRule();
$segmentation_rule->setId(7);

$output = $whatcounts->deleteSegmentationRule($segmentation_rule);
```


####Test Segmentation Rule

```php
$segmentation_rule = new ZayconWhatCounts\SegmentationRule();
$segmentation_rule->setId(8);
$segmentation_rule->setListId(14);

$output = $whatcounts->testSegmentationRule($segmentation_rule);
```


###Social
####Get All Social Providers```php

```php
$output = $whatcounts->getSocialProviders();
```


####Get Social Provider by ID
```php
$social_provider = new ZayconWhatCounts\SocialProvider();
$social_provider->setProviderId(522);

$whatcounts->getSocialProviderById($social_provider);
```


####Get Social Provider by Username
```php
$social_provider = new ZayconWhatCounts\SocialProvider();
$social_provider
	->setUsername('user@example.com')
	->setProviderName('facebook');

$whatcounts->getSocialProviderByUserName($social_provider);
```


####Delete Social Provider by ID
```php
$social_provider = new ZayconWhatCounts\SocialProvider();
$social_provider->setProviderId(522);

$is_deleted = $whatcounts->deleteSocialProviderById($social_provider);
```


####Delete Social Provider by Username
```php
$social_provider = new ZayconWhatCounts\SocialProvider();
$social_provider
	->setUsername('Joe Smith')
	->setProviderName('linkedin');

$is_deleted = $whatcounts->deleteSocialProviderByUserName($social_provider);
```


####Set Social Post for Template
```php
$template = new ZayconWhatCounts\Template();	$template->setTemplateId(14);

$social_provider = new ZayconWhatCounts\SocialProvider();
$social_provider->setProviderName('twitter');

$social_post = new ZayconWhatCounts\SocialPost();
$social_post->setPost('This is a post created from the API.');

$output = $whatcounts->setSocialPostForTemplate($template, $social_provider, $social_post);
```


####Get Social Posts by Template ID
```php
$template = new ZayconWhatCounts\Template();
$template->setTemplateId(14);

$output = $whatcounts->getSocialPostsByTemplateId($template);
```


####Get Social Posts by Template Name
```php
$template = new ZayconWhatCounts\Template();
$template->setName('Test Template');

$output = $whatcounts->getSocialPostsByTemplateName($template);
```


###Reporting
####Show Campaigns
```php
$count = 5;
$output = $whatcounts->showCampaigns($count);
```


####Report Campaign List
```php
$start_date = "01/01/2016";
$end_date = "03/01/2016";
$show_hidden = 0;

$output = $whatcounts->reportCampaignList($start_date, $end_date, $show_hidden);
```


####Show Campaign Statistics
```php
$campaign_statistics = new ZayconWhatCounts\Report();
$campaign_statistics->setCampaignId(43);

$whatcounts->showCampaignStatistics($campaign_statistics);
```


####Show Multiple Campaign Statistics
```php
$campaign_ids = array(43,7);

$output = $whatcounts->showMultipleCampaginStatistics($campaign_ids);
```


####Report Campaign Clicks
```php
$campaign_id = 47;
$output = $whatcounts->reportCampaignClicks($campaign_id);
```


####Report Subscriber Clicks
```php
$campaign_id = 47;
$url = 'https://www.example.com';
$is_exact = FALSE;
$is_unique = FALSE;

$output = $whatcounts->reportSubscriberClicks($campaign_id, $url, $is_exact, $is_unique);
```


####Report Daily Statistics
```php
$campaign_id = 47;
$start_date = '2/1/2016';
$end_date = '4/1/2016';

$output = $whatcounts->reportDailyStatistics($campaign_id, $start_date, $end_date);
```


####Report Browser Info
```php
$campaign_id = 13;
$by_subscriber = 1;
$os_name = 'ios';
$browser = 'safari';
$client_type = 'iphone';

$output = $whatcounts->reportBrowserInfo($campaign_id, $by_subscriber, $os_name, $browser, $client_type);
```


####Report Bounce Statistics
```php
define('BOUNCE_TYPE_SOFT', 30);
define('BOUNCE_TYPE_HARD', 31);
define('BOUNCE_TYPE_COMPLAINT', 34);
define('BOUNCE_TYPE_BLOCK', 36);

$campaign_id = 47;
$start_date = '2/1/2016';
$end_date = '4/1/2016';
$bounce_type = BOUNCE_TYPE_HARD;

$output = $whatcounts->reportBounceStatistics($campaign_id, $bounce_type, $start_date, $end_date);
```


####Report Tracked Events
```php
define('EVENT_TYPE_NONE', 0);
define('EVENT_TYPE_SENT', 9);
define('EVENT_TYPE_OPEN', 10);
define('EVENT_TYPE_CLICKTHROUGH', 11);
define('EVENT_TYPE_SNA_SHARING', 13);
define('EVENT_TYPE_SUBSCRIBE', 20);
define('EVENT_TYPE_UNSUBSCRIBE', 21);
define('EVENT_TYPE_GLOBAL_UNSUBSCRIBE', 22);
define('EVENT_TYPE_UNIVERSAL_UNSUBSCRIBE', 23);
define('EVENT_TYPE_SOFT_BOUNCE', 30);
define('EVENT_TYPE_HARD_BOUNCE', 31);
define('EVENT_TYPE_DATA_SET', 32);
define('EVENT_TYPE_CONFIRMATION MESSAGE', 33);
define('EVENT_TYPE_ABUSE', 34);
define('EVENT_TYPE_INVALID_EMAIL_ADDRESS', 35);
define('EVENT_TYPE_BLOCKED', 36);
define('EVENT_TYPE_DISPLAY_MSG', 40);
define('EVENT_TYPE_SNA_DISPLAY_MESSAGE', 41);
define('EVENT_TYPE_VIDEO_DISPLAY_MSG', 42);
define('EVENT_TYPE_MOBILE_DISPLAY_MSG', 43);
define('EVENT_TYPE_FTAF', 50);
define('EVENT_TYPE_FTAF_ANON', 51);
define('EVENT_TYPE_USER_LOGIN', 60);
define('EVENT_TYPE_USER_LOGOUT', 61);
define('EVENT_TYPE_USER_PASSWORD_CHANGE', 62);
define('EVENT_TYPE_SENDMESSAGE', 70);
define('EVENT_TYPE_SNA_POST_MESSAGE', 71);
define('EVENT_TYPE_SENDMESSAGE_CC', 72);
define('EVENT_TYPE_CONVERSION_DEEPLINK_TRACKING', 80);
define('EVENT_TYPE_CLICK_PREF_UNSUB', 81);
define('EVENT_TYPE_CLICK_PREF_MANAGER', 82);
define('EVENT_TYPE_CLICK_PREF_SUB', 83);
define('EVENT_TYPE_RSS_VISIT', 102);
define('EVENT_TYPE_SUPPRESS', 103);
define('EVENT_TYPE_ANALYTICS_ABANDONMENT', 121);
define('EVENT_TYPE_ANALYTICS_PURCHASES', 122);
define('EVENT_TYPE_ANALYTICS_VIEWS', 123);
define('EVENT_TYPE_VIDEO_LOADED', 130);
define('EVENT_TYPE_VIDEO_PLAYED', 131);
define('EVENT_TYPE_VIDEO_PAUSED', 132);
define('EVENT_TYPE_VIDEO_STOPPED', 133);
define('EVENT_TYPE_VIDEO_INTERRUPTED', 134);
define('EVENT_TYPE_VIDEO_CHECK_POINT_25', 135);
define('EVENT_TYPE_VIDEO_CHECK_POINT_50', 136);
define('EVENT_TYPE_VIDEO_CHECK_POINT_75', 137);
define('EVENT_TYPE_VIDEO_COMPLETED', 138);
define('EVENT_TYPE_SNA_DIGG_VIEW', 151);
define('EVENT_TYPE_SNA_DIGG_SHARE', 152);
define('EVENT_TYPE_SNA_FACEBOOK_VIEW', 153);
define('EVENT_TYPE_SNA_FACEBOOK_SHARE', 154);
define('EVENT_TYPE_SNA_LINKEDIN_VIEW', 155);
define('EVENT_TYPE_SNA_LINKEDIN_SHARE', 156);
define('EVENT_TYPE_SNA_MYSPACE_VIEW', 157);
define('EVENT_TYPE_SNA_MYSPACE_SHARE', 158);
define('EVENT_TYPE_SNA_PING_VIEW', 159);
define('EVENT_TYPE_SNA_PING_SHARE', 160);
define('EVENT_TYPE_SNA_TWITTER_VIEW', 161);	define('EVENT_TYPE_SNA_TWITTER_SHARE', 162);
define('EVENT_TYPE_SNA_GOOGLEPLUS_VIEW', 163);
define('EVENT_TYPE_SNA_GOOGLEPLUS_SHARE', 164);
define('EVENT_TYPE_SNA_STUMBLEUPON_VIEW', 165);
define('EVENT_TYPE_SNA_STUMBLEUPON_SHARE', 166);
define('EVENT_TYPE_SNA_PINTEREST_VIEW', 167);
define('EVENT_TYPE_SNA_PINTEREST_SHARE', 168);
define('EVENT_TYPE_SOFT_BOUNCE_UNSUBSCRIBE', 230);
define('EVENT_TYPE_SNA_DIGG_CLICKTHROUGH', 301);
define('EVENT_TYPE_SNA_FACEBOOK_CLICKTHROUGH', 302);
define('EVENT_TYPE_SNA_LINKEDIN_CLICKTHROUGH', 303);
define('EVENT_TYPE_SNA_MYSPACE_CLICKTHROUGH', 304);
define('EVENT_TYPE_SNA_PING_CLICKTHROUGH', 305);	define('EVENT_TYPE_SNA_TWITTER_CLICKTHROUGH', 306);
define('EVENT_TYPE_SNA_GOOGLEPLUS_CLICKTHROUGH', 307);
define('EVENT_TYPE_SNA_STUMBLEUPON_CLICKTHROUGH', 308);
define('EVENT_TYPE_SNA_PINTEREST_CLICKTHROUGH', 309);
define('EVENT_TYPE_SNA_FACEBOOK_POST', 401);
define('EVENT_TYPE_SNA_LINKEDIN_POST', 402);
define('EVENT_TYPE_SNA_TWITTER_POST', 403);
define('EVENT_TYPE_PROFILE_MANAGER', 999999);

$event_type = EVENT_TYPE_CLICKTHROUGH;
$start_datetime = '02/01/2016 13:00:00';
$end_datetime = '03/01/2016 13:00:00';
$offset = 0;

$output = $whatcounts->reportTrackedEvents($event_type, $start_datetime, $end_datetime, $offset);
```


####Report Tracked Events by Campaign
```php
define('EVENT_TYPE_NONE', 0);
define('EVENT_TYPE_SENT', 9);
define('EVENT_TYPE_OPEN', 10);
define('EVENT_TYPE_CLICKTHROUGH', 11);
define('EVENT_TYPE_SNA_SHARING', 13);
define('EVENT_TYPE_SUBSCRIBE', 20);
define('EVENT_TYPE_UNSUBSCRIBE', 21);
define('EVENT_TYPE_GLOBAL_UNSUBSCRIBE', 22);
define('EVENT_TYPE_UNIVERSAL_UNSUBSCRIBE', 23);
define('EVENT_TYPE_SOFT_BOUNCE', 30);
define('EVENT_TYPE_HARD_BOUNCE', 31);
define('EVENT_TYPE_DATA_SET', 32);
define('EVENT_TYPE_CONFIRMATION MESSAGE', 33);
define('EVENT_TYPE_ABUSE', 34);
define('EVENT_TYPE_INVALID_EMAIL_ADDRESS', 35);
define('EVENT_TYPE_BLOCKED', 36);
define('EVENT_TYPE_DISPLAY_MSG', 40);
define('EVENT_TYPE_SNA_DISPLAY_MESSAGE', 41);
define('EVENT_TYPE_VIDEO_DISPLAY_MSG', 42);
define('EVENT_TYPE_MOBILE_DISPLAY_MSG', 43);
define('EVENT_TYPE_FTAF', 50);
define('EVENT_TYPE_FTAF_ANON', 51);
define('EVENT_TYPE_USER_LOGIN', 60);
define('EVENT_TYPE_USER_LOGOUT', 61);
define('EVENT_TYPE_USER_PASSWORD_CHANGE', 62);
define('EVENT_TYPE_SENDMESSAGE', 70);
define('EVENT_TYPE_SNA_POST_MESSAGE', 71);
define('EVENT_TYPE_SENDMESSAGE_CC', 72);
define('EVENT_TYPE_CONVERSION_DEEPLINK_TRACKING', 80);
define('EVENT_TYPE_CLICK_PREF_UNSUB', 81);
define('EVENT_TYPE_CLICK_PREF_MANAGER', 82);
define('EVENT_TYPE_CLICK_PREF_SUB', 83);
define('EVENT_TYPE_RSS_VISIT', 102);
define('EVENT_TYPE_SUPPRESS', 103);
define('EVENT_TYPE_ANALYTICS_ABANDONMENT', 121);
define('EVENT_TYPE_ANALYTICS_PURCHASES', 122);
define('EVENT_TYPE_ANALYTICS_VIEWS', 123);
define('EVENT_TYPE_VIDEO_LOADED', 130);
define('EVENT_TYPE_VIDEO_PLAYED', 131);
define('EVENT_TYPE_VIDEO_PAUSED', 132);
define('EVENT_TYPE_VIDEO_STOPPED', 133);
define('EVENT_TYPE_VIDEO_INTERRUPTED', 134);
define('EVENT_TYPE_VIDEO_CHECK_POINT_25', 135);
define('EVENT_TYPE_VIDEO_CHECK_POINT_50', 136);
define('EVENT_TYPE_VIDEO_CHECK_POINT_75', 137);
define('EVENT_TYPE_VIDEO_COMPLETED', 138);
define('EVENT_TYPE_SNA_DIGG_VIEW', 151);
define('EVENT_TYPE_SNA_DIGG_SHARE', 152);
define('EVENT_TYPE_SNA_FACEBOOK_VIEW', 153);
define('EVENT_TYPE_SNA_FACEBOOK_SHARE', 154);
define('EVENT_TYPE_SNA_LINKEDIN_VIEW', 155);
define('EVENT_TYPE_SNA_LINKEDIN_SHARE', 156);
define('EVENT_TYPE_SNA_MYSPACE_VIEW', 157);
define('EVENT_TYPE_SNA_MYSPACE_SHARE', 158);
define('EVENT_TYPE_SNA_PING_VIEW', 159);
define('EVENT_TYPE_SNA_PING_SHARE', 160);
define('EVENT_TYPE_SNA_TWITTER_VIEW', 161);	define('EVENT_TYPE_SNA_TWITTER_SHARE', 162);
define('EVENT_TYPE_SNA_GOOGLEPLUS_VIEW', 163);
define('EVENT_TYPE_SNA_GOOGLEPLUS_SHARE', 164);
define('EVENT_TYPE_SNA_STUMBLEUPON_VIEW', 165);
define('EVENT_TYPE_SNA_STUMBLEUPON_SHARE', 166);
define('EVENT_TYPE_SNA_PINTEREST_VIEW', 167);
define('EVENT_TYPE_SNA_PINTEREST_SHARE', 168);
define('EVENT_TYPE_SOFT_BOUNCE_UNSUBSCRIBE', 230);
define('EVENT_TYPE_SNA_DIGG_CLICKTHROUGH', 301);
define('EVENT_TYPE_SNA_FACEBOOK_CLICKTHROUGH', 302);
define('EVENT_TYPE_SNA_LINKEDIN_CLICKTHROUGH', 303);
define('EVENT_TYPE_SNA_MYSPACE_CLICKTHROUGH', 304);
define('EVENT_TYPE_SNA_PING_CLICKTHROUGH', 305);	define('EVENT_TYPE_SNA_TWITTER_CLICKTHROUGH', 306);
define('EVENT_TYPE_SNA_GOOGLEPLUS_CLICKTHROUGH', 307);
define('EVENT_TYPE_SNA_STUMBLEUPON_CLICKTHROUGH', 308);
define('EVENT_TYPE_SNA_PINTEREST_CLICKTHROUGH', 309);
define('EVENT_TYPE_SNA_FACEBOOK_POST', 401);
define('EVENT_TYPE_SNA_LINKEDIN_POST', 402);
define('EVENT_TYPE_SNA_TWITTER_POST', 403);
define('EVENT_TYPE_PROFILE_MANAGER', 999999);

$campaign_id = 47;
$event_type = EVENT_TYPE_CLICKTHROUGH;
$start_datetime = '02/01/2016 13:00:00';	$end_datetime = '03/16/2016 13:00:00';
$offset = 0;

$output = $whatcounts->reportTrackedEventsByCampaign($campaign_id, $event_type, $start_datetime, $end_datetime, $offset);
```


####Show Hard Bounces
```php
$list_id = 13;
$days = 45;

$output = $whatcounts->showHardBounces($list_id, $days);
```


####Show Soft Bounces
```php
$list_id = 13;
$days = 45;

$output = $whatcounts->showSoftBounces($list_id, $days);
```


####Show Block Bounces
```php
$list_id = 13;
$days = 45;

$output = $whatcounts->showBlockBounces($list_id, $days);
```


####Show Complaints
```php
$list_id = 13;
$days = 45;

$output = $whatcounts->showComplaints($list_id, $days);
```


####Report Subscriber by Update
```php
$list_id = 13;
$start_datetime = '2/1/2016 12:00:00';
$end_datetime = '4/1/2016 11:59:59';

$output = $whatcounts->reportSubscriberByUpdate($list_id, $start_datetime, $end_datetime);
```


####Report Subscribers in List

```php
$list_id = 13;
$offset = 0;

$output = $whatcounts->reportSubscribersInList($list_id, $offset);
```


----
## <a name="todo"></a>@todo


####A/B Testing
- chooseABWinner: Choose A/B Winner

####Articles
- createArticle: Create Article

####Folders
- createFolder: Create Folder
- getFolderById: Get Folder ID

####Send Mail
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


###API Issues

These commands do not return well formed XML, and thus need to return data in CSV form:

- rpt_bounce_stats
- rpt_abstats
- showarticlelist
- show_campaigns
- show_campaign_stats_multi
- show_lists
- show_seg
- show_templates
- show_user_events

These commands do not properly return a FAILURE (when test returns no results):

- findinlist
- find

Using API version 8.4.0 causes command 'detail' to return incomplete XML

Executing command subandsend sends email and adds subscriber but doesn't seem to add to a list.

createarticle returns "FAILURE: cannot create article [article_name]"

show_campaign_list returns track_clicks twice. One as true/false, one as yes/no.

rpt_bounce_stats seems to ignore bounce_type and returns all bounce_type values.

----
## <a name="about"></a>About
Developed by [Zaycon Fresh](https://www.zayconfresh.com)


