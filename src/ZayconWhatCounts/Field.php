<?php
    /**
     * Created by PhpStorm.
     * User: marksimonds
     * Date: 1/28/16
     * Time: 9:51 AM
     */

    namespace ZayconWhatCounts;

    /**
     * Class Field
     * @package ZayconWhatCounts
     */
    class Field
    {
        private $name;
        private $type;
        private $description;

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
         * @return Field
         */
        public function setName($name)
        {
            $this->name = $name;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getType()
        {
            return $this->type;
        }

        /**
         * @param mixed $type
         *
         * @return Field
         */
        public function setType($type)
        {
            $this->type = $type;

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
         * @return Field
         */
        public function setDescription($description)
        {
            $this->description = $description;

            return $this;
        }


    }