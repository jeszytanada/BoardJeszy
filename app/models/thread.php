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
            'format' => array(
                'check_space_format', "Invalid Title"
            ),
        ),
    );
    
    /** 
     * Get all the Threads from Database
     * Sort by Rating then if rating = 0,
     * Sort by date created
     * @param $all_threads
     * @return $threads
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
     * @param $thread_id
     * @return thread row
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
     * @param $comment
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
     * @param $star_count (user rate)
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
     * @return count of all id
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
     * @param $user_id
     */
    public function delete($user_id)
    {   
        
        if ($this->user_id != $user_id) {
            throw new ValidationException(notify('Restrict Deletion: You do not own this Thread',"error"));
        }
        try {
            $db = DB::conn();
            $db->begin();
            $db->query("DELETE FROM thread WHERE id = ? AND user_id = ?", 
                array($this->id, $this->user_id));
            $db->query("DELETE FROM comment WHERE thread_id = ?", 
                array($this->id));
            $db->commit();
        } catch (ValidationException $e) {
            $db->rollback();
            throw $e;
        }
    }
    
     /**
     * Edit title of Thread by the Owner.
     * Compares the user_id (from thread table) 
     * to the user_id from session
     * @param $user_id
     */
    public function update($user_id) 
    {
        if ($this->user_id != $user_id) {
            throw new ValidationException(notify('Restrict Update: Not owner of the Thread',"error"));
        }
        if (!$this->validate()) {
            throw new ValidationException(notify('Thread Title Error',"error"));
        }
        try {
            $params = array(
                'title'   => $this->title,
                'updated' => date('Y-m-d h:i:s')
            );
            $db = DB::conn();
            $db->update('thread', $params, array('id' => $this->id));
        } catch (ValidationException $e) {
            throw $e;
        }
    }   
}
