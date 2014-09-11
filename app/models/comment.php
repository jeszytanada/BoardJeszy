<?php
class Comment extends Appmodel{
	
const MIN_VAL = 1;
const MAX_USER = 16;
const MAX_COMMENT =200;

public $validation =array('username' => array(
							  'length' => array(
								'validate_between',self::MIN_VAL,self::MAX_USER,
								),
							),
							'body' => array(
							   'length'=>array(
								 'validate_between',self::MIN_VAL,self::MAX_COMMENT,
								),
							),
					);
}
