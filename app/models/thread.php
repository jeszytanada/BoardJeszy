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
    * After selecting thread,checks the ID in the Database then return.
    * If ID is not found -> @throw exception 
    */
    public static function get($id) 
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id = ?',array($id));
        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }
        return new self($row);
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
                $this->write($comment);
                $db->commit();
            } catch (ValidationException $e) {
                $db->rollback();
                throw $e;
              }
    }

    /** 
    * Validate first the Comment.
    * Write comment in an existing Thread. 
    * Insert to the Database.
    */
    public function write(Comment $comment) 
    {
        if (!$comment->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $db->query('INSERT INTO comment SET thread_id = ?, username = ?, body = ?, created = NOW()',
        array($this->id,$comment->username,$comment->body));
    }   

    /**
    * Function used for Pagination
    * Returns the total count of thread ID 
    */
    public static function count() 
    {
        $db = DB::conn();
        $total_thread = $db->value("SELECT COUNT(id) FROM thread");
        return $total_thread;
    }   
}
