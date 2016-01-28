<?php
    /**
     * Created by PhpStorm.
     * User: marksimonds
     * Date: 1/27/16
     * Time: 8:52 AM
     */

    namespace ZayconWhatCounts;

    /**
     * Class ABTest
     * @package ZayconWhatCounts
     */
    class ABTest
    {
        private $id;
        private $name;
        private $description;
        private $list_id;
        private $list_name;
        private $segmentation_rule_id;
        private $suppression_list;
        private $max_time;
        private $measuring;
        private $num_samples;
        private $sample_size;
        private $sample_type;
        private $test_subject;
        private $test_from_address;
        private $test_content;
        private $test_ends_when;
        private $threshold;
        private $post_test_action;

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         *
         * @return ABTest
         */
        public function setId($id)
        {
            $this->id = $id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param mixed $name
         *
         * @return ABTest
         */
        public function setName($name)
        {
            $this->name = $name;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getDescription()
        {
            return $this->description;
        }

        /**
         * @param mixed $description
         *
         * @return ABTest
         */
        public function setDescription($description)
        {
            $this->description = $description;

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
         * @return ABTest
         */
        public function setListId($list_id)
        {
            $this->list_id = $list_id;

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
         * @return ABTest
         */
        public function setListName($list_name)
        {
            $this->list_name = $list_name;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSegmentationRuleId()
        {
            return $this->segmentation_rule_id;
        }

        /**
         * @param mixed $segmentation_rule_id
         *
         * @return ABTest
         */
        public function setSegmentationRuleId($segmentation_rule_id)
        {
            $this->segmentation_rule_id = $segmentation_rule_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSuppressionList()
        {
            return $this->suppression_list;
        }

        /**
         * @param mixed $suppression_list
         *
         * @return ABTest
         */
        public function setSuppressionList($suppression_list)
        {
            $this->suppression_list = $suppression_list;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMaxTime()
        {
            return $this->max_time;
        }

        /**
         * @param mixed $max_time
         *
         * @return ABTest
         */
        public function setMaxTime($max_time)
        {
            $this->max_time = $max_time;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMeasuring()
        {
            return $this->measuring;
        }

        /**
         * @param mixed $measuring
         *
         * @return ABTest
         */
        public function setMeasuring($measuring)
        {
            $this->measuring = $measuring;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getNumSamples()
        {
            return $this->num_samples;
        }

        /**
         * @param mixed $num_samples
         *
         * @return ABTest
         */
        public function setNumSamples($num_samples)
        {
            $this->num_samples = $num_samples;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSampleSize()
        {
            return $this->sample_size;
        }

        /**
         * @param mixed $sample_size
         *
         * @return ABTest
         */
        public function setSampleSize($sample_size)
        {
            $this->sample_size = $sample_size;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getSampleType()
        {
            return $this->sample_type;
        }

        /**
         * @param mixed $sample_type
         *
         * @return ABTest
         */
        public function setSampleType($sample_type)
        {
            $this->sample_type = $sample_type;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTestSubject()
        {
            return $this->test_subject;
        }

        /**
         * @param mixed $test_subject
         *
         * @return ABTest
         */
        public function setTestSubject($test_subject)
        {
            $this->test_subject = $test_subject;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTestFromAddress()
        {
            return $this->test_from_address;
        }

        /**
         * @param mixed $test_from_address
         *
         * @return ABTest
         */
        public function setTestFromAddress($test_from_address)
        {
            $this->test_from_address = $test_from_address;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTestContent()
        {
            return $this->test_content;
        }

        /**
         * @param mixed $test_content
         *
         * @return ABTest
         */
        public function setTestContent($test_content)
        {
            $this->test_content = $test_content;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getTestEndsWhen()
        {
            return $this->test_ends_when;
        }

        /**
         * @param mixed $test_ends_when
         *
         * @return ABTest
         */
        public function setTestEndsWhen($test_ends_when)
        {
            $this->test_ends_when = $test_ends_when;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getThreshold()
        {
            return $this->threshold;
        }

        /**
         * @param mixed $threshold
         *
         * @return ABTest
         */
        public function setThreshold($threshold)
        {
            $this->threshold = $threshold;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getPostTestAction()
        {
            return $this->post_test_action;
        }

        /**
         * @param mixed $post_test_action
         *
         * @return ABTest
         */
        public function setPostTestAction($post_test_action)
        {
            $this->post_test_action = $post_test_action;

            return $this;
        }


    }