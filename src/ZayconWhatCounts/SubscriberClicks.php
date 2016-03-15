<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 3/11/16
	 * Time: 1:09 PM
	 */

	namespace ZayconWhatCounts;


	class SubscriberClicks
	{
		private $email;
		private $first_name;
		private $last_name;
		private $event_date;

		/**
		 * @return mixed
		 */
		public function getEmail()
		{
			return $this->email;
		}

		/**
		 * @param mixed $email
		 *
		 * @return SubscriberClicks
		 */
		public function setEmail($email)
		{
			$this->email = $email;

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getFirstName()
		{
			return $this->first_name;
		}

		/**
		 * @param mixed $first_name
		 *
		 * @return SubscriberClicks
		 */
		public function setFirstName($first_name)
		{
			$this->first_name = $first_name;

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getLastName()
		{
			return $this->last_name;
		}

		/**
		 * @param mixed $last_name
		 *
		 * @return SubscriberClicks
		 */
		public function setLastName($last_name)
		{
			$this->last_name = $last_name;

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getEventDate()
		{
			return $this->event_date;
		}

		/**
		 * @param mixed $event_date
		 *
		 * @return SubscriberClicks
		 */
		public function setEventDate($event_date)
		{
			$this->event_date = $event_date;

			return $this;
		}

	}