<?php
class Thread extends AppModel 
{  
    public $validation = array(
        'title' => array(
            'length'=> array(
                'validate_between',1,30,
            ),
        ),
    );
    
    /** 
    * Get all the Threads from Database 
    */
    public static function getAll($all_threads) 
    {   
        $threads = array();
        $db = DB::conn();
        $rows = $db->rows("SELECT * FROM thread $all_threads");
        foreach ($rows as $row) { 
            $threads[] = new Thread($row);
        }
        return $threads;    
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
                'title' => $this->title,
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
    * Function used for Pagination
    * Returns the total count of thread ID 
    */
    public static function count() 
    {
        $db = DB::conn();
        return $db->value("SELECT COUNT(id) FROM thread");
    }   
}
