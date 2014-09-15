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

    /** Get all Comments inside a Thread displayed in Ascending order **/
    public static function getComments($id) {
        $comments = array();
        $db = DB::conn();
        $rows = $db->rows('SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC',array($id));
        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }
        return $comments;
    }
}
