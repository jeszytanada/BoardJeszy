<?php
class Comment extends Appmodel 
{
    
    const MIN_COMMENT = 1;
    const MAX_COMMENT = 500;

    public $validation = array(
        'body' => array(
            'length'=> array(
                'validate_between', self::MIN_COMMENT, self::MAX_COMMENT,
            ),
            'format' => array(
                'is_valid_space', "Invalid Comment"
            ),
        ),
    );

    /** 
     * Get all Comments of a Thread
     * Ascending order
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
     * Function to get Comment.
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
            throw new ValidationException('Invalid comment');
        }
        $db = DB::conn();
        $params = array(
            'thread_id' => $thread_id,
            'username'  => $this->username,
            'body'      => $this->body,
        );
        $db->insert('comment', $params);
    }

    /** 
     * Deletion of Comment by owner
     * @param username from Session and Confirm deletion
     */
    public function delete($username)
    {   
        if ($this->username != $username) {
                throw new ValidationException(notify("Restrict Deletion: User {$username} do not own this Comment","error"));
        }
        $db = DB::conn();
        $db->query("DELETE FROM comment WHERE id = ? AND username = ?", array($this->id, $this->username));
    }
}
