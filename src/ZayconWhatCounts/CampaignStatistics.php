<?php
    /**
     * Created by PhpStorm.
     * User: marksimonds
     * Date: 1/28/16
     * Time: 11:00 AM
     */

    namespace ZayconWhatCounts;


    class CampaignStatistics
    {
        private $campaign_id;
        private $list_name;
        private $list_id;
        private $subject;
        private $date;
        private $recipients;
        private $alias;
        private $template_name;
        private $segmentation;
        private $active;
        private $set_macro_id;
        private $character_set;
        private $unicode;
        private $quoted_printable;
        private $forced_format;
        private $deployed_by;
        private $auto_multipart;
        private $wrap_plain;
        private $wrap_html;
        private $track_opens;
        private $track_clicks;
        private $total_ftaf;
        private $total_opened_unique;
        private $compliant_bounces;

        private $social_shares;
        private $social_views;
        private $social_clicks;
        private $social_provider_count;
        private $digg_shares;
        private $digg_views;
        private $digg_clicks;
        private $facebook_shares;
        private $facebook_views;
        private $facebook_clicks;
        private $linkedin_shares;
        private $linkedin_views;
        private $linkedin_clicks;
        private $myspace_shares;
        private $myspace_views;
        private $myspace_clicks;
        private $twitter_shares;
        private $twitter_views;
        private $twitter_clicks;
        private $google_plus_shares;
        private $google_plus_views;
        private $google_plus_clicks;
        private $stumbleupon_shares;
        private $stumbleupon_views;
        private $stumbleupon_clicks;
        private $pinterest_shares;
        private $pinterest_views;
        private $pinterest_clicks;

        /**
         * @return mixed
         */
        public function getCampaignId()
        {
            return $this->campaign_id;
        }

        /**
         * @param mixed $campaign_id
         *
         * @return CampaignStatistics
         */
        public function setCampaignId($campaign_id)
        {
            $this->campaign_id = $campaign_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getListName()
        {
            return $this->list_name;
        }

        /**
         * @param mixed $list_name
         *
         * @return CampaignStatistics
         */
        public function setListName($list_name)
        {
            $this->list_name = $list_name;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getListId()
        {
            return $this->list_id;
        }

        /**
         * @param mixed $list_id
         *
         * @return CampaignStatistics
         */
        public function setListId($list_id)
        {
            $this->list_id = $list_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSubject()
        {
            return $this->subject;
        }

        /**
         * @param mixed $subject
         *
         * @return CampaignStatistics
         */
        public function setSubject($subject)
        {
            $this->subject = $subject;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDate()
        {
            return $this->date;
        }

        /**
         * @param mixed $date
         *
         * @return CampaignStatistics
         */
        public function setDate($date)
        {
            $this->date = $date;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getRecipients()
        {
            return $this->recipients;
        }

        /**
         * @param mixed $recipients
         *
         * @return CampaignStatistics
         */
        public function setRecipients($recipients)
        {
            $this->recipients = $recipients;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getAlias()
        {
            return $this->alias;
        }

        /**
         * @param mixed $alias
         *
         * @return CampaignStatistics
         */
        public function setAlias($alias)
        {
            $this->alias = $alias;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTemplateName()
        {
            return $this->template_name;
        }

        /**
         * @param mixed $template_name
         *
         * @return CampaignStatistics
         */
        public function setTemplateName($template_name)
        {
            $this->template_name = $template_name;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSegmentation()
        {
            return $this->segmentation;
        }

        /**
         * @param mixed $segmentation
         *
         * @return CampaignStatistics
         */
        public function setSegmentation($segmentation)
        {
            $this->segmentation = $segmentation;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getActive()
        {
            return $this->active;
        }

        /**
         * @param mixed $active
         *
         * @return CampaignStatistics
         */
        public function setActive($active)
        {
            $this->active = $active;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSetMacroId()
        {
            return $this->set_macro_id;
        }

        /**
         * @param mixed $set_macro_id
         *
         * @return CampaignStatistics
         */
        public function setSetMacroId($set_macro_id)
        {
            $this->set_macro_id = $set_macro_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getCharacterSet()
        {
            return $this->character_set;
        }

        /**
         * @param mixed $character_set
         *
         * @return CampaignStatistics
         */
        public function setCharacterSet($character_set)
        {
            $this->character_set = $character_set;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getUnicode()
        {
            return $this->unicode;
        }

        /**
         * @param mixed $unicode
         *
         * @return CampaignStatistics
         */
        public function setUnicode($unicode)
        {
            $this->unicode = $unicode;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getQuotedPrintable()
        {
            return $this->quoted_printable;
        }

        /**
         * @param mixed $quoted_printable
         *
         * @return CampaignStatistics
         */
        public function setQuotedPrintable($quoted_printable)
        {
            $this->quoted_printable = $quoted_printable;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getForcedFormat()
        {
            return $this->forced_format;
        }

        /**
         * @param mixed $forced_format
         *
         * @return CampaignStatistics
         */
        public function setForcedFormat($forced_format)
        {
            $this->forced_format = $forced_format;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDeployedBy()
        {
            return $this->deployed_by;
        }

        /**
         * @param mixed $deployed_by
         *
         * @return CampaignStatistics
         */
        public function setDeployedBy($deployed_by)
        {
            $this->deployed_by = $deployed_by;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getAutoMultipart()
        {
            return $this->auto_multipart;
        }

        /**
         * @param mixed $auto_multipart
         *
         * @return CampaignStatistics
         */
        public function setAutoMultipart($auto_multipart)
        {
            $this->auto_multipart = $auto_multipart;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getWrapPlain()
        {
            return $this->wrap_plain;
        }

        /**
         * @param mixed $wrap_plain
         *
         * @return CampaignStatistics
         */
        public function setWrapPlain($wrap_plain)
        {
            $this->wrap_plain = $wrap_plain;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getWrapHtml()
        {
            return $this->wrap_html;
        }

        /**
         * @param mixed $wrap_html
         *
         * @return CampaignStatistics
         */
        public function setWrapHtml($wrap_html)
        {
            $this->wrap_html = $wrap_html;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTrackOpens()
        {
            return $this->track_opens;
        }

        /**
         * @param mixed $track_opens
         *
         * @return CampaignStatistics
         */
        public function setTrackOpens($track_opens)
        {
            $this->track_opens = $track_opens;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTrackClicks()
        {
            return $this->track_clicks;
        }

        /**
         * @param mixed $track_clicks
         *
         * @return CampaignStatistics
         */
        public function setTrackClicks($track_clicks)
        {
            $this->track_clicks = $track_clicks;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTotalFtaf()
        {
            return $this->total_ftaf;
        }

        /**
         * @param mixed $total_ftaf
         *
         * @return CampaignStatistics
         */
        public function setTotalFtaf($total_ftaf)
        {
            $this->total_ftaf = $total_ftaf;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTotalOpenedUnique()
        {
            return $this->total_opened_unique;
        }

        /**
         * @param mixed $total_opened_unique
         *
         * @return CampaignStatistics
         */
        public function setTotalOpenedUnique($total_opened_unique)
        {
            $this->total_opened_unique = $total_opened_unique;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getCompliantBounces()
        {
            return $this->compliant_bounces;
        }

        /**
         * @param mixed $compliant_bounces
         *
         * @return CampaignStatistics
         */
        public function setCompliantBounces($compliant_bounces)
        {
            $this->compliant_bounces = $compliant_bounces;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSocialShares()
        {
            return $this->social_shares;
        }

        /**
         * @param mixed $social_shares
         *
         * @return CampaignStatistics
         */
        public function setSocialShares($social_shares)
        {
            $this->social_shares = $social_shares;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSocialViews()
        {
            return $this->social_views;
        }

        /**
         * @param mixed $social_views
         *
         * @return CampaignStatistics
         */
        public function setSocialViews($social_views)
        {
            $this->social_views = $social_views;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSocialClicks()
        {
            return $this->social_clicks;
        }

        /**
         * @param mixed $social_clicks
         *
         * @return CampaignStatistics
         */
        public function setSocialClicks($social_clicks)
        {
            $this->social_clicks = $social_clicks;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSocialProviderCount()
        {
            return $this->social_provider_count;
        }

        /**
         * @param mixed $social_provider_count
         *
         * @return CampaignStatistics
         */
        public function setSocialProviderCount($social_provider_count)
        {
            $this->social_provider_count = $social_provider_count;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDiggShares()
        {
            return $this->digg_shares;
        }

        /**
         * @param mixed $digg_shares
         *
         * @return CampaignStatistics
         */
        public function setDiggShares($digg_shares)
        {
            $this->digg_shares = $digg_shares;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDiggViews()
        {
            return $this->digg_views;
        }

        /**
         * @param mixed $digg_views
         *
         * @return CampaignStatistics
         */
        public function setDiggViews($digg_views)
        {
            $this->digg_views = $digg_views;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDiggClicks()
        {
            return $this->digg_clicks;
        }

        /**
         * @param mixed $digg_clicks
         *
         * @return CampaignStatistics
         */
        public function setDiggClicks($digg_clicks)
        {
            $this->digg_clicks = $digg_clicks;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getFacebookShares()
        {
            return $this->facebook_shares;
        }

        /**
         * @param mixed $facebook_shares
         *
         * @return CampaignStatistics
         */
        public function setFacebookShares($facebook_shares)
        {
            $this->facebook_shares = $facebook_shares;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getFacebookViews()
        {
            return $this->facebook_views;
        }

        /**
         * @param mixed $facebook_views
         *
         * @return CampaignStatistics
         */
        public function setFacebookViews($facebook_views)
        {
            $this->facebook_views = $facebook_views;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getFacebookClicks()
        {
            return $this->facebook_clicks;
        }

        /**
         * @param mixed $facebook_clicks
         *
         * @return CampaignStatistics
         */
        public function setFacebookClicks($facebook_clicks)
        {
            $this->facebook_clicks = $facebook_clicks;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getLinkedinShares()
        {
            return $this->linkedin_shares;
        }

        /**
         * @param mixed $linkedin_shares
         *
         * @return CampaignStatistics
         */
        public function setLinkedinShares($linkedin_shares)
        {
            $this->linkedin_shares = $linkedin_shares;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getLinkedinViews()
        {
            return $this->linkedin_views;
        }

        /**
         * @param mixed $linkedin_views
         *
         * @return CampaignStatistics
         */
        public function setLinkedinViews($linkedin_views)
        {
            $this->linkedin_views = $linkedin_views;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getLinkedinClicks()
        {
            return $this->linkedin_clicks;
        }

        /**
         * @param mixed $linkedin_clicks
         *
         * @return CampaignStatistics
         */
        public function setLinkedinClicks($linkedin_clicks)
        {
            $this->linkedin_clicks = $linkedin_clicks;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMyspaceShares()
        {
            return $this->myspace_shares;
        }

        /**
         * @param mixed $myspace_shares
         *
         * @return CampaignStatistics
         */
        public function setMyspaceShares($myspace_shares)
        {
            $this->myspace_shares = $myspace_shares;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMyspaceViews()
        {
            return $this->myspace_views;
        }

        /**
         * @param mixed $myspace_views
         *
         * @return CampaignStatistics
         */
        public function setMyspaceViews($myspace_views)
        {
            $this->myspace_views = $myspace_views;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMyspaceClicks()
        {
            return $this->myspace_clicks;
        }

        /**
         * @param mixed $myspace_clicks
         *
         * @return CampaignStatistics
         */
        public function setMyspaceClicks($myspace_clicks)
        {
            $this->myspace_clicks = $myspace_clicks;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTwitterShares()
        {
            return $this->twitter_shares;
        }

        /**
         * @param mixed $twitter_shares
         *
         * @return CampaignStatistics
         */
        public function setTwitterShares($twitter_shares)
        {
            $this->twitter_shares = $twitter_shares;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTwitterViews()
        {
            return $this->twitter_views;
        }

        /**
         * @param mixed $twitter_views
         *
         * @return CampaignStatistics
         */
        public function setTwitterViews($twitter_views)
        {
            $this->twitter_views = $twitter_views;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTwitterClicks()
        {
            return $this->twitter_clicks;
        }

        /**
         * @param mixed $twitter_clicks
         *
         * @return CampaignStatistics
         */
        public function setTwitterClicks($twitter_clicks)
        {
            $this->twitter_clicks = $twitter_clicks;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getGooglePlusShares()
        {
            return $this->google_plus_shares;
        }

        /**
         * @param mixed $google_plus_shares
         *
         * @return CampaignStatistics
         */
        public function setGooglePlusShares($google_plus_shares)
        {
            $this->google_plus_shares = $google_plus_shares;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getGooglePlusViews()
        {
            return $this->google_plus_views;
        }

        /**
         * @param mixed $google_plus_views
         *
         * @return CampaignStatistics
         */
        public function setGooglePlusViews($google_plus_views)
        {
            $this->google_plus_views = $google_plus_views;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getGooglePlusClicks()
        {
            return $this->google_plus_clicks;
        }

        /**
         * @param mixed $google_plus_clicks
         *
         * @return CampaignStatistics
         */
        public function setGooglePlusClicks($google_plus_clicks)
        {
            $this->google_plus_clicks = $google_plus_clicks;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getStumbleuponShares()
        {
            return $this->stumbleupon_shares;
        }

        /**
         * @param mixed $stumbleupon_shares
         *
         * @return CampaignStatistics
         */
        public function setStumbleuponShares($stumbleupon_shares)
        {
            $this->stumbleupon_shares = $stumbleupon_shares;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getStumbleuponViews()
        {
            return $this->stumbleupon_views;
        }

        /**
         * @param mixed $stumbleupon_views
         *
         * @return CampaignStatistics
         */
        public function setStumbleuponViews($stumbleupon_views)
        {
            $this->stumbleupon_views = $stumbleupon_views;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getStumbleuponClicks()
        {
            return $this->stumbleupon_clicks;
        }

        /**
         * @param mixed $stumbleupon_clicks
         *
         * @return CampaignStatistics
         */
        public function setStumbleuponClicks($stumbleupon_clicks)
        {
            $this->stumbleupon_clicks = $stumbleupon_clicks;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getPinterestShares()
        {
            return $this->pinterest_shares;
        }

        /**
         * @param mixed $pinterest_shares
         *
         * @return CampaignStatistics
         */
        public function setPinterestShares($pinterest_shares)
        {
            $this->pinterest_shares = $pinterest_shares;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getPinterestViews()
        {
            return $this->pinterest_views;
        }

        /**
         * @param mixed $pinterest_views
         *
         * @return CampaignStatistics
         */
        public function setPinterestViews($pinterest_views)
        {
            $this->pinterest_views = $pinterest_views;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getPinterestClicks()
        {
            return $this->pinterest_clicks;
        }

        /**
         * @param mixed $pinterest_clicks
         *
         * @return CampaignStatistics
         */
        public function setPinterestClicks($pinterest_clicks)
        {
            $this->pinterest_clicks = $pinterest_clicks;

            return $this;
        }


    }