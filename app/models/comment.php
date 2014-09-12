<?php
class Comment extends Appmodel 
{
    
    const MIN_COMMENT = 1;
    const MAX_COMMENT =200;

    public $validation = array(
        'body' => array(
            'length'=>array(
                'validate_between',self::MIN_COMMENT,self::MAX_COMMENT,
            ),
        ),
    );
}
