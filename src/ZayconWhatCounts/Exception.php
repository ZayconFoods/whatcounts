<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 1/21/16
 * Time: 2:20 PM
 */

namespace ZayconWhatCounts;

class Exception extends \Exception {

	function __construct( $message, $code=0, \Exception $previous=NULL)
	{
		parent::__construct( $message, $code, $previous );
	}
}