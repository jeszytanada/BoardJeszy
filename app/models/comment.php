<?php
class Comment extends Appmodel 
{
    
    const MIN_COMMENT = 1;
    const MAX_COMMENT = 200;

    public $validation = array(
        'body' => array(
            'length'=>array(
                'validate_between', self::MIN_COMMENT, self::MAX_COMMENT,
            ),
        ),
    );

    /** 
     * Get all Comments of a Thread in Ascending order
     * Then extract the contents of the comment table
     * And return the comments.
     * @param thread id
     * @return array comment (contains all comments) 
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
     * Function to get the Comment Id.
     * @param comment id
     * @return comment matched to id
     */
    public static function get($comment_id) 
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM comment WHERE id = ?', array($comment_id));
        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }
        return new self($row);
    }

    /** 
     * Validate first the Comment.
     * Write comment in an existing Thread. 
     * Insert to the Database.
     * @param thread id
     */
    public function write($thread_id) 
    {   
        if (!$this->validate()) {
            throw new ValidationException('invalid comment');
        }
        try {
            $db = DB::conn();
            $db->begin();
            $params = array(
                'thread_id' => $thread_id,
                'username'  => $this->username,
                'body'      => $this->body,
            );
            $db->insert('comment', $params);
            $db->commit();
        } catch (ValidationException $e) {
            $db->rollback();
            throw $e;
        }
        
    }

    /** 
     * Deletion of Comment according to ID
     * and owner (username).
     * @param username from Session and Confirm deletion
     */
    public function delete($username, $reply)
    {   
        try {
            if ($this->username == $username) {
                $db = DB::conn();
                $db->query("DELETE FROM comment WHERE id = ? AND username = ?", 
                    array($this->id, $this->username));
            }
            if ($this->username != $username) {
                throw new AppException('Restrict Deletion');
            }
        } catch (ValidationException $e) {
            throw $e;
            $db->rollback();
        }
    }      
}
