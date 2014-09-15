<?php
class CommentController extends AppController
{
    /** 
    * Displays specific Thread and its containing Comments
    */
    public function view() 
    {    
        $thread = Thread::get(Param::get('thread_id'));
        $comments = Comment::getComments($thread->id);
        $this->set(get_defined_vars());
    }
}
