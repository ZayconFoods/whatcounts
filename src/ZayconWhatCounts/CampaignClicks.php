<?php
    /**
     * Created by PhpStorm.
     * User: marksimonds
     * Date: 1/28/16
     * Time: 11:34 AM
     */

    namespace ZayconWhatCounts;


    class CampaignClicks
    {
        private $url;
        private $total_clicks;
        private $unique_clicks;
        private $tracking_url_id;

        /**
         * @return mixed
         */
        public function getUrl()
        {
            return $this->url;
        }

        /**
         * @param mixed $url
         *
         * @return CampaignClicks
         */
        public function setUrl($url)
        {
            $this->url = $url;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTotalClicks()
        {
            return $this->total_clicks;
        }

        /**
         * @param mixed $total_clicks
         *
         * @return CampaignClicks
         */
        public function setTotalClicks($total_clicks)
        {
            $this->total_clicks = $total_clicks;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getUniqueClicks()
        {
            return $this->unique_clicks;
        }

        /**
         * @param mixed $unique_clicks
         *
         * @return CampaignClicks
         */
        public function setUniqueClicks($unique_clicks)
        {
            $this->unique_clicks = $unique_clicks;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTrackingUrlId()
        {
            return $this->tracking_url_id;
        }

        /**
         * @param mixed $tracking_url_id
         *
         * @return CampaignClicks
         */
        public function setTrackingUrlId($tracking_url_id)
        {
            $this->tracking_url_id = $tracking_url_id;

            return $this;
        }

    }