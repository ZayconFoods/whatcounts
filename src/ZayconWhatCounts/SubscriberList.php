<?php
    /**
     * Created by PhpStorm.
     * User: marksimonds
     * Date: 1/29/16
     * Time: 2:55 PM
     */

    namespace ZayconWhatCounts;


    class SubscriberList
    {
        private $list_id;
        private $created_date;
        private $last_sent;
        private $sent_flag = FALSE;
        private $format;

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
         * @return SubscriberList
         */
        public function setListId($list_id)
        {
            $this->list_id = $list_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getCreatedDate()
        {
            return $this->created_date;
        }

        /**
         * @param mixed $created_date
         *
         * @return SubscriberList
         */
        public function setCreatedDate($created_date)
        {
            $this->created_date = $created_date;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getLastSent()
        {
            return $this->last_sent;
        }

        /**
         * @param mixed $last_sent
         *
         * @return SubscriberList
         */
        public function setLastSent($last_sent)
        {
            $this->last_sent = $last_sent;

            return $this;
        }

        /**
         * @return mixed
         */
        public function isSentFlag()
        {
            return $this->sent_flag;
        }

        /**
         * @param mixed $sent_flag
         *
         * @return SubscriberList
         */
        public function setSentFlag($sent_flag)
        {
            $this->sent_flag = ($sent_flag == 1 || $sent_flag == 'Y' || $sent_flag === TRUE) ? TRUE : FALSE;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getFormat()
        {
            return $this->format;
        }

        /**
         * @param mixed $format
         *
         * @return SubscriberList
         */
        public function setFormat($format)
        {
            $this->format = $format;

            return $this;
        }

    }