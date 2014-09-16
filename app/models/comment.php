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
    public static function getComments($thread_id) 
    {
        $comments = array();
        $db = DB::conn();
        $rows = $db->rows('SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC', array($thread_id));
        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }
        return $comments;
    }

    /** 
    * After selecting thread,checks the ID in the Database then return.
    * If ID is not found -> @throw exception 
    */
    public static function get($thread_id) 
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id = ?',array($thread_id));
        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }
        return new self($row);
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
