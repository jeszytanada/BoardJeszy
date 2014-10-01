<?php
class Thread extends AppModel 
{  
    const MIN_TITLE = 1;
    const MAX_TITLE = 30;
    
    public $validation = array(
        'title' => array(
            'length'=> array(
                'validate_between', self::MIN_TITLE, self::MAX_TITLE,
            ),
        ),
    );
    
    /** 
     * Get all the Threads from Database
     * Sort by Rating then if 0 = rating,
     * by latest date created  
     */
    public static function getAll($all_threads) 
    {   
        $threads = array();
        $db = DB::conn();
        $rows = $db->rows("SELECT * FROM thread ORDER BY rating DESC, created DESC $all_threads");
        foreach ($rows as $row) { 
            $threads[] = new self ($row);
        }
        return $threads;    
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
     * Gets all comments using thread ID
     */ 
    public function getComments()
    {
        return Comment::getAllByThread($this->id);
    }

    /** 
     * Validate first the Thread & Comment.
     * If both hasError() -> throw Exception
     * Get title of Thread, Get Comment
     * Insert to the Database.
     */
    public function create(Comment $comment) 
    {   
        $this->validate();
        $comment->validate();
        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('Invalid thread or comment');
        }
        $db = DB::conn();
        try{    
            $db->begin();
            $params = array(
                'user_id' => $this->user_id,
                'title'   => $this->title
            );
            $db->insert('thread',$params);
            $this->id = $db->lastInsertId();
            $comment->write($this->id);
            $db->commit();
        } catch (ValidationException $e) {
            $db->rollback();
            throw $e;
        }
    }

    /** 
     * Will increase the current rating
     * by adding the number of stars.
     */
    public function increaseRate($star_count)
    {   
        $this->rating += $star_count;
        $db = DB::conn();
        $db->update('thread', array('rating' => $this->rating), array('id' => $this->id));
    }

    /**
     * Function used for Pagination
     * Returns the total count of thread ID 
     */
    public static function count() 
    {
        $db = DB::conn();
        return $db->value("SELECT COUNT(id) FROM thread");
    }

    /**
     * Deletion of Thread by the Owner.
     * Compares the user_id used to create a thread
     * (from thread table) to the user_id from session
     */
    public function delete($user_id, $reply)
    {   
        try {
            if ($this->user_id == $user_id) {
                $db = DB::conn();
                $db->query("DELETE FROM thread WHERE id = ? AND user_id = ?", 
                    array($this->id, $this->user_id));
                $db->query("DELETE FROM comment WHERE thread_id = ?", 
                    array($this->id));
            }
            if ($this->user_id != $user_id) {
                throw new AppException('Restrict Deletion');
            }
        } catch (ValidationException $e) {
            throw $e;
            $db->rollback();
        }
    }   
}
