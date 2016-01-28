<?php
    /**
     * Created by PhpStorm.
     * User: marksimonds
     * Date: 1/27/16
     * Time: 4:36 PM
     */

    namespace ZayconWhatCounts;


    /**
     * Class ABTestStatistics
     * @package ZayconWhatCounts
     */
    class ABTestStatistics
    {

        private $ab_test_id;
        private $sample;
        private $encrypted_id;
        private $ab_definition_id;
        private $ab_result_id;
        private $ab_result_sample_id;
        private $template_id;
        private $template_name;
        private $subject;
        private $from_address;
        private $campaign_id;
        private $is_winner;
        private $is_deployed;
        private $unique_open_rate;
        private $unique_click_rate;
        private $total_sent;
        private $total_delivered;
        private $unique_hard_bounce;
        private $unique_soft_bounce;
        private $unique_blocked;
        private $total_complaints;
        private $total_responders;
        private $total_unsubscribes;
        private $unique_complaints;
        private $click_to_open_rate;
        private $open_rate;
        private $responder_rate;
        private $unsubscribe_rate;
        private $click_rate;
        private $complaint_rate;
        private $hard_bounce_rate;
        private $soft_bounce_rate;
        private $blocked_rate;
        private $delivered_rate;
        private $fb_posts;
        private $fb_displays;
        private $fb_unique_posts;
        private $fb_unique_displays;
        private $tw_posts;
        private $tw_displays;
        private $tw_unique_posts;
        private $tw_unique_displays;
        private $ln_posts;
        private $ln_displays;
        private $ln_unique_posts;
        private $ln_unique_displays;
        private $dg_posts;
        private $dg_displays;
        private $dg_unique_posts;
        private $dg_unique_displays;
        private $msp_posts;
        private $msp_displays;
        private $msp_unique_posts;
        private $msp_unique_displays;
        private $video_played;
        private $video_check_25;
        private $video_check_50;
        private $video_check_75;
        private $video_check_completed;
        private $total_hard_bounce;
        private $total_soft_bounce;
        private $total_blocked;
        private $social_shares;
        private $social_views;
        private $social_clicks;

        /**
         * @return mixed
         */
        public function getAbTestId()
        {
            return $this->ab_test_id;
        }

        /**
         * @param mixed $ab_test_id
         *
         * @return ABTestStatistics
         */
        public function setAbTestId($ab_test_id)
        {
            $this->ab_test_id = $ab_test_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSample()
        {
            return $this->sample;
        }

        /**
         * @param mixed $sample
         *
         * @return ABTestStatistics
         */
        public function setSample($sample)
        {
            $this->sample = $sample;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getEncryptedId()
        {
            return $this->encrypted_id;
        }

        /**
         * @param mixed $encrypted_id
         *
         * @return ABTestStatistics
         */
        public function setEncryptedId($encrypted_id)
        {
            $this->encrypted_id = $encrypted_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getAbDefinitionId()
        {
            return $this->ab_definition_id;
        }

        /**
         * @param mixed $ab_definition_id
         *
         * @return ABTestStatistics
         */
        public function setAbDefinitionId($ab_definition_id)
        {
            $this->ab_definition_id = $ab_definition_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getAbResultId()
        {
            return $this->ab_result_id;
        }

        /**
         * @param mixed $ab_result_id
         *
         * @return ABTestStatistics
         */
        public function setAbResultId($ab_result_id)
        {
            $this->ab_result_id = $ab_result_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getAbResultSampleId()
        {
            return $this->ab_result_sample_id;
        }

        /**
         * @param mixed $ab_result_sample_id
         *
         * @return ABTestStatistics
         */
        public function setAbResultSampleId($ab_result_sample_id)
        {
            $this->ab_result_sample_id = $ab_result_sample_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTemplateId()
        {
            return $this->template_id;
        }

        /**
         * @param mixed $template_id
         *
         * @return ABTestStatistics
         */
        public function setTemplateId($template_id)
        {
            $this->template_id = $template_id;

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
         * @return ABTestStatistics
         */
        public function setTemplateName($template_name)
        {
            $this->template_name = $template_name;

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
         * @return ABTestStatistics
         */
        public function setSubject($subject)
        {
            $this->subject = $subject;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getFromAddress()
        {
            return $this->from_address;
        }

        /**
         * @param mixed $from_address
         *
         * @return ABTestStatistics
         */
        public function setFromAddress($from_address)
        {
            $this->from_address = $from_address;

            return $this;
        }

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
         * @return ABTestStatistics
         */
        public function setCampaignId($campaign_id)
        {
            $this->campaign_id = $campaign_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getIsWinner()
        {
            return $this->is_winner;
        }

        /**
         * @param mixed $is_winner
         *
         * @return ABTestStatistics
         */
        public function setIsWinner($is_winner)
        {
            $this->is_winner = $is_winner;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getIsDeployed()
        {
            return $this->is_deployed;
        }

        /**
         * @param mixed $is_deployed
         *
         * @return ABTestStatistics
         */
        public function setIsDeployed($is_deployed)
        {
            $this->is_deployed = $is_deployed;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getUniqueOpenRate()
        {
            return $this->unique_open_rate;
        }

        /**
         * @param mixed $unique_open_rate
         *
         * @return ABTestStatistics
         */
        public function setUniqueOpenRate($unique_open_rate)
        {
            $this->unique_open_rate = $unique_open_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getUniqueClickRate()
        {
            return $this->unique_click_rate;
        }

        /**
         * @param mixed $unique_click_rate
         *
         * @return ABTestStatistics
         */
        public function setUniqueClickRate($unique_click_rate)
        {
            $this->unique_click_rate = $unique_click_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTotalSent()
        {
            return $this->total_sent;
        }

        /**
         * @param mixed $total_sent
         *
         * @return ABTestStatistics
         */
        public function setTotalSent($total_sent)
        {
            $this->total_sent = $total_sent;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTotalDelivered()
        {
            return $this->total_delivered;
        }

        /**
         * @param mixed $total_delivered
         *
         * @return ABTestStatistics
         */
        public function setTotalDelivered($total_delivered)
        {
            $this->total_delivered = $total_delivered;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getUniqueHardBounce()
        {
            return $this->unique_hard_bounce;
        }

        /**
         * @param mixed $unique_hard_bounce
         *
         * @return ABTestStatistics
         */
        public function setUniqueHardBounce($unique_hard_bounce)
        {
            $this->unique_hard_bounce = $unique_hard_bounce;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getUniqueSoftBounce()
        {
            return $this->unique_soft_bounce;
        }

        /**
         * @param mixed $unique_soft_bounce
         *
         * @return ABTestStatistics
         */
        public function setUniqueSoftBounce($unique_soft_bounce)
        {
            $this->unique_soft_bounce = $unique_soft_bounce;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getUniqueBlocked()
        {
            return $this->unique_blocked;
        }

        /**
         * @param mixed $unique_blocked
         *
         * @return ABTestStatistics
         */
        public function setUniqueBlocked($unique_blocked)
        {
            $this->unique_blocked = $unique_blocked;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTotalComplaints()
        {
            return $this->total_complaints;
        }

        /**
         * @param mixed $total_complaints
         *
         * @return ABTestStatistics
         */
        public function setTotalComplaints($total_complaints)
        {
            $this->total_complaints = $total_complaints;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTotalResponders()
        {
            return $this->total_responders;
        }

        /**
         * @param mixed $total_responders
         *
         * @return ABTestStatistics
         */
        public function setTotalResponders($total_responders)
        {
            $this->total_responders = $total_responders;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTotalUnsubscribes()
        {
            return $this->total_unsubscribes;
        }

        /**
         * @param mixed $total_unsubscribes
         *
         * @return ABTestStatistics
         */
        public function setTotalUnsubscribes($total_unsubscribes)
        {
            $this->total_unsubscribes = $total_unsubscribes;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getUniqueComplaints()
        {
            return $this->unique_complaints;
        }

        /**
         * @param mixed $unique_complaints
         *
         * @return ABTestStatistics
         */
        public function setUniqueComplaints($unique_complaints)
        {
            $this->unique_complaints = $unique_complaints;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getClickToOpenRate()
        {
            return $this->click_to_open_rate;
        }

        /**
         * @param mixed $click_to_open_rate
         *
         * @return ABTestStatistics
         */
        public function setClickToOpenRate($click_to_open_rate)
        {
            $this->click_to_open_rate = $click_to_open_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getOpenRate()
        {
            return $this->open_rate;
        }

        /**
         * @param mixed $open_rate
         *
         * @return ABTestStatistics
         */
        public function setOpenRate($open_rate)
        {
            $this->open_rate = $open_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getResponderRate()
        {
            return $this->responder_rate;
        }

        /**
         * @param mixed $responder_rate
         *
         * @return ABTestStatistics
         */
        public function setResponderRate($responder_rate)
        {
            $this->responder_rate = $responder_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getUnsubscribeRate()
        {
            return $this->unsubscribe_rate;
        }

        /**
         * @param mixed $unsubscribe_rate
         *
         * @return ABTestStatistics
         */
        public function setUnsubscribeRate($unsubscribe_rate)
        {
            $this->unsubscribe_rate = $unsubscribe_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getClickRate()
        {
            return $this->click_rate;
        }

        /**
         * @param mixed $click_rate
         *
         * @return ABTestStatistics
         */
        public function setClickRate($click_rate)
        {
            $this->click_rate = $click_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getComplaintRate()
        {
            return $this->complaint_rate;
        }

        /**
         * @param mixed $complaint_rate
         *
         * @return ABTestStatistics
         */
        public function setComplaintRate($complaint_rate)
        {
            $this->complaint_rate = $complaint_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getHardBounceRate()
        {
            return $this->hard_bounce_rate;
        }

        /**
         * @param mixed $hard_bounce_rate
         *
         * @return ABTestStatistics
         */
        public function setHardBounceRate($hard_bounce_rate)
        {
            $this->hard_bounce_rate = $hard_bounce_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSoftBounceRate()
        {
            return $this->soft_bounce_rate;
        }

        /**
         * @param mixed $soft_bounce_rate
         *
         * @return ABTestStatistics
         */
        public function setSoftBounceRate($soft_bounce_rate)
        {
            $this->soft_bounce_rate = $soft_bounce_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getBlockedRate()
        {
            return $this->blocked_rate;
        }

        /**
         * @param mixed $blocked_rate
         *
         * @return ABTestStatistics
         */
        public function setBlockedRate($blocked_rate)
        {
            $this->blocked_rate = $blocked_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDeliveredRate()
        {
            return $this->delivered_rate;
        }

        /**
         * @param mixed $delivered_rate
         *
         * @return ABTestStatistics
         */
        public function setDeliveredRate($delivered_rate)
        {
            $this->delivered_rate = $delivered_rate;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getFbPosts()
        {
            return $this->fb_posts;
        }

        /**
         * @param mixed $fb_posts
         *
         * @return ABTestStatistics
         */
        public function setFbPosts($fb_posts)
        {
            $this->fb_posts = $fb_posts;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getFbDisplays()
        {
            return $this->fb_displays;
        }

        /**
         * @param mixed $fb_displays
         *
         * @return ABTestStatistics
         */
        public function setFbDisplays($fb_displays)
        {
            $this->fb_displays = $fb_displays;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getFbUniquePosts()
        {
            return $this->fb_unique_posts;
        }

        /**
         * @param mixed $fb_unique_posts
         *
         * @return ABTestStatistics
         */
        public function setFbUniquePosts($fb_unique_posts)
        {
            $this->fb_unique_posts = $fb_unique_posts;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getFbUniqueDisplays()
        {
            return $this->fb_unique_displays;
        }

        /**
         * @param mixed $fb_unique_displays
         *
         * @return ABTestStatistics
         */
        public function setFbUniqueDisplays($fb_unique_displays)
        {
            $this->fb_unique_displays = $fb_unique_displays;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTwPosts()
        {
            return $this->tw_posts;
        }

        /**
         * @param mixed $tw_posts
         *
         * @return ABTestStatistics
         */
        public function setTwPosts($tw_posts)
        {
            $this->tw_posts = $tw_posts;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTwDisplays()
        {
            return $this->tw_displays;
        }

        /**
         * @param mixed $tw_displays
         *
         * @return ABTestStatistics
         */
        public function setTwDisplays($tw_displays)
        {
            $this->tw_displays = $tw_displays;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTwUniquePosts()
        {
            return $this->tw_unique_posts;
        }

        /**
         * @param mixed $tw_unique_posts
         *
         * @return ABTestStatistics
         */
        public function setTwUniquePosts($tw_unique_posts)
        {
            $this->tw_unique_posts = $tw_unique_posts;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTwUniqueDisplays()
        {
            return $this->tw_unique_displays;
        }

        /**
         * @param mixed $tw_unique_displays
         *
         * @return ABTestStatistics
         */
        public function setTwUniqueDisplays($tw_unique_displays)
        {
            $this->tw_unique_displays = $tw_unique_displays;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getLnPosts()
        {
            return $this->ln_posts;
        }

        /**
         * @param mixed $ln_posts
         *
         * @return ABTestStatistics
         */
        public function setLnPosts($ln_posts)
        {
            $this->ln_posts = $ln_posts;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getLnDisplays()
        {
            return $this->ln_displays;
        }

        /**
         * @param mixed $ln_displays
         *
         * @return ABTestStatistics
         */
        public function setLnDisplays($ln_displays)
        {
            $this->ln_displays = $ln_displays;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getLnUniquePosts()
        {
            return $this->ln_unique_posts;
        }

        /**
         * @param mixed $ln_unique_posts
         *
         * @return ABTestStatistics
         */
        public function setLnUniquePosts($ln_unique_posts)
        {
            $this->ln_unique_posts = $ln_unique_posts;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getLnUniqueDisplays()
        {
            return $this->ln_unique_displays;
        }

        /**
         * @param mixed $ln_unique_displays
         *
         * @return ABTestStatistics
         */
        public function setLnUniqueDisplays($ln_unique_displays)
        {
            $this->ln_unique_displays = $ln_unique_displays;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDgPosts()
        {
            return $this->dg_posts;
        }

        /**
         * @param mixed $dg_posts
         *
         * @return ABTestStatistics
         */
        public function setDgPosts($dg_posts)
        {
            $this->dg_posts = $dg_posts;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDgDisplays()
        {
            return $this->dg_displays;
        }

        /**
         * @param mixed $dg_displays
         *
         * @return ABTestStatistics
         */
        public function setDgDisplays($dg_displays)
        {
            $this->dg_displays = $dg_displays;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDgUniquePosts()
        {
            return $this->dg_unique_posts;
        }

        /**
         * @param mixed $dg_unique_posts
         *
         * @return ABTestStatistics
         */
        public function setDgUniquePosts($dg_unique_posts)
        {
            $this->dg_unique_posts = $dg_unique_posts;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDgUniqueDisplays()
        {
            return $this->dg_unique_displays;
        }

        /**
         * @param mixed $dg_unique_displays
         *
         * @return ABTestStatistics
         */
        public function setDgUniqueDisplays($dg_unique_displays)
        {
            $this->dg_unique_displays = $dg_unique_displays;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMspPosts()
        {
            return $this->msp_posts;
        }

        /**
         * @param mixed $msp_posts
         *
         * @return ABTestStatistics
         */
        public function setMspPosts($msp_posts)
        {
            $this->msp_posts = $msp_posts;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMspDisplays()
        {
            return $this->msp_displays;
        }

        /**
         * @param mixed $msp_displays
         *
         * @return ABTestStatistics
         */
        public function setMspDisplays($msp_displays)
        {
            $this->msp_displays = $msp_displays;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMspUniquePosts()
        {
            return $this->msp_unique_posts;
        }

        /**
         * @param mixed $msp_unique_posts
         *
         * @return ABTestStatistics
         */
        public function setMspUniquePosts($msp_unique_posts)
        {
            $this->msp_unique_posts = $msp_unique_posts;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMspUniqueDisplays()
        {
            return $this->msp_unique_displays;
        }

        /**
         * @param mixed $msp_unique_displays
         *
         * @return ABTestStatistics
         */
        public function setMspUniqueDisplays($msp_unique_displays)
        {
            $this->msp_unique_displays = $msp_unique_displays;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getVideoPlayed()
        {
            return $this->video_played;
        }

        /**
         * @param mixed $video_played
         *
         * @return ABTestStatistics
         */
        public function setVideoPlayed($video_played)
        {
            $this->video_played = $video_played;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getVideoCheck25()
        {
            return $this->video_check_25;
        }

        /**
         * @param mixed $video_check_25
         *
         * @return ABTestStatistics
         */
        public function setVideoCheck25($video_check_25)
        {
            $this->video_check_25 = $video_check_25;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getVideoCheck50()
        {
            return $this->video_check_50;
        }

        /**
         * @param mixed $video_check_50
         *
         * @return ABTestStatistics
         */
        public function setVideoCheck50($video_check_50)
        {
            $this->video_check_50 = $video_check_50;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getVideoCheck75()
        {
            return $this->video_check_75;
        }

        /**
         * @param mixed $video_check_75
         *
         * @return ABTestStatistics
         */
        public function setVideoCheck75($video_check_75)
        {
            $this->video_check_75 = $video_check_75;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getVideoCheckCompleted()
        {
            return $this->video_check_completed;
        }

        /**
         * @param mixed $video_check_completed
         *
         * @return ABTestStatistics
         */
        public function setVideoCheckCompleted($video_check_completed)
        {
            $this->video_check_completed = $video_check_completed;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTotalHardBounce()
        {
            return $this->total_hard_bounce;
        }

        /**
         * @param mixed $total_hard_bounce
         *
         * @return ABTestStatistics
         */
        public function setTotalHardBounce($total_hard_bounce)
        {
            $this->total_hard_bounce = $total_hard_bounce;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTotalSoftBounce()
        {
            return $this->total_soft_bounce;
        }

        /**
         * @param mixed $total_soft_bounce
         *
         * @return ABTestStatistics
         */
        public function setTotalSoftBounce($total_soft_bounce)
        {
            $this->total_soft_bounce = $total_soft_bounce;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTotalBlocked()
        {
            return $this->total_blocked;
        }

        /**
         * @param mixed $total_blocked
         *
         * @return ABTestStatistics
         */
        public function setTotalBlocked($total_blocked)
        {
            $this->total_blocked = $total_blocked;

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
         * @return ABTestStatistics
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
         * @return ABTestStatistics
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
         * @return ABTestStatistics
         */
        public function setSocialClicks($social_clicks)
        {
            $this->social_clicks = $social_clicks;

            return $this;
        }

    }