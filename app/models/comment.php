<?php
class Comment extends Appmodel
{
	const MIN = 1;
	const MAX_USER = 16;
	const MAX_COMMENT =200;

	public $validation = array( 'username' => array(
									'length' => array(
										'validate_between',self::MIN,self::MAX_USER,
									),
								),
								'body' => array(
									'length'=>array(
										'validate_between',self::MIN,self::MAX_COMMENT,
									),
								),
						);
}