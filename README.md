# whatcounts
PHP API Wrapper for WhatCounts Email System

----
##Available commands

####Realms
getrealmsettings: Get Realm Settings


####Lists

createlist: Create List

excreatelist: Create List

show\_lists: Show Lists

getlistbyid: Get List by ID

getlistbyname: Get List by Name

updatelist: Update List


----
##@todo


####A/B Testing
abmailwinner: Choose A/B Winner

getabdefinitionbyid: Get A/B Definition

show\_abdefinitions: Show A/B Definitions

rpt\_abstats: Report A/B Test Statistics


####Articles

createarticle: Create Article

createblankarticle: Create Article Blank

getarticlewithid: Get Article by ID

getarticlewithname: Get Article by Name

updatearticle: Update Article

deletearticle: Delete Article

copyarticle: Copy Article


####Folders
createfolderpath: Create Folder

getfolderidbypath: Get Folder ID


####Lists

rpt\_subscribers\_in\_list: Report Subscribers in List


####Templates
createtemplate: Create Template

show\_templates: Show Templates

gettemplatebyid: Get Template by ID

gettemplatebyname: Get Template by Name

updatetemplate: Update Template

templatepreview: Preview Template


####Segmentation Rules

createseg: Create Segmentation Rule

show\_seg: Show Segmentation Rules

updateseg: Update Segmentation Rule

testseg: Test Segmentation Rule

deleteseg: Delete Segmentation Rule


####Social

getsocialproviders: Get All Social Providers

getsocialproviderbyid: Get Social Provider by ID

getsocialproviderbyusername: Get Social Provider by Username

getsocialpostsfortemplatebyid: Get Social Posts by Template ID

getsocialpostsfortemplatebyname: Get Social Posts by Template Name

deletesocialproviderbyid: Delete Social Provider by ID

deletesocialproviderbyusername: Delete Social Provider by Username

setsocialpostfortemplate: Set Social Post for Template


####Subscriber Management

sub: Subscribe

unsub: Unsubscribe

delete: Delete Subscriber

detail: Show Subscriber Details

find: Find Subscriber

findinlist: Find Subscriber in List

update: Update Subscriber

change: Change Email Address

addtolifecyclecampaign: Add Subscriber to Lifecycle Campaign


####Send Mail

send: Send One-Off Message

subandsend: Subscribe and Send One-Off Message

launch: Launch Campaign

schedule\_deployment: Schedule Campaign Deployment

springbot\_process\_abandoned\_cart: Process Abandoned Cart


####Campaigns

show\_block: Show Block Bounces

show\_campaign\_stats: Show Campaign Statistics

show\_campaign\_stats\_multi: Show Multiple Campaign Statistics

show\_campaigns: Show Campaigns

show\_complaint: Show Complaints

show\_hard: Show Hard Bounces

show\_opt: Show Optouts

show\_optglobal: Show Global Optouts

show\_soft: Show Soft Bounces

show\_user\_events: Show User Events

showarticlelist: Show Articles


####Relational Data

relationalactivatefield: Activate Field

relationalactivatetable: Activate Table

relationaladdfield: Add Field

relationaladdtable: Add Table

relationaldelete: Delete Data

relationalfind: Find Data

relationalfindfield: Find Field

relationalfindtables: Find Table

relationalsave: Save Data


####Reporting

rpt\_bounce\_stats: Report Bounce Statistics

rpt\_browser\_info: Report Browser Info

rpt\_campaign\_list: Report Campaign List

rpt\_click\_overview: Report Campaign Clicks

rpt\_clicked\_on: Report Subscriber Clicks

rpt\_daily\_stats: Report Daily Statistics

rpt\_sub\_by\_update\_datetime: Report Subscriber by Update

rpt\_subscriber\_events: Report Subscriber Events

rpt\_tracked\_events: Report Tracked Events

rpt\_tracked\_events\_by\_campaign: Report Tracked Events by Campaign

rpt\_unsubscribe: Report Unsubscribes