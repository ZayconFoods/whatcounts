# whatcounts
PHP API Wrapper for WhatCounts Email System

----
##Available functions

####Realms
- getRealmSettings: Get Realm Settings

####Lists
- showLists: Show Lists
- getListById: Get List by ID
- getListByName: Get List by Name
- exCreateList: Create List
- createList: Create List
- updateList: Update List

####Subscriber Management
- findSubscribers: Find Subscriber
- findSubscriberInList: Find Subscriber in List
- sub: Subscribe
- unsubscribe: Unsubscribe
- deleteSubscriber: Delete Subscriber
- showSubscriber: Show Subscriber Details
- updateSubscriber: Update Subscriber
- changeEmailAddress: Change Email Address
- addSubscriberToLifecycleCampaign: Add Subscriber to Lifecycle Campaign

####Send Mail
- sendOneOffMessage: Send One-Off Message
- subscribeAndSendOneOffMessage: Subscribe and Send One-Off Message

####Reporting
- showUserEvents: Show User Events
- reportSubscriberEvents: Report Subscriber Events

----
##@todo


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
- reportUnsubscribes: Report Unsubscribes
- showOptouts: Show Optouts
- showGlobalOptouts: Show Global Optouts
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
