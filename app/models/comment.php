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

    /** 
    * Get all Comments inside a Thread displayed in Ascending order 
    */
    public static function getAllByThread($thread_id) 
    {
        $comments = array();
        $db = DB::conn();
        $rows = $db->rows('SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC', array($thread_id));
        foreach ($rows as $row) {
            $comments[] = new self($row);
        }
        return $comments;
    }

    /** 
    * Validate first the Comment.
    * Write comment in an existing Thread. 
    * Insert to the Database.
    */
    public function write($thread_id) 
    {   
        if (!$this->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $params = array(
            'thread_id' => $thread_id,
            'username'  => $this->username,
            'body'      => $this->body,
        );
        $db->insert('comment', $params);
        
    }   
}
