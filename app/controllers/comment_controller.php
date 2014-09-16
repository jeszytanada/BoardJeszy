<?php
class CommentController extends AppController
{
    /** 
    * Displays specific Thread and its containing Comments
    */
    public function view() 
    {    
        $thread = Comment::get(Param::get('thread_id'));
        $comments = $thread->getComments();
        $this->set(get_defined_vars());
    }

    /**
    * Get Thread thru id
    * Write comment to existing Thread
    */
    public function write() 
    {
        $comment = new Comment;
        $thread = Comment::get(Param::get('thread_id'));
        $page = Param::get('page_next','write');
        switch($page) {
            case 'write':
                break;

            case 'write_end':
                $comment->username = $_SESSION['username'];
                $comment->body = Param::get('body');
                try {
                    $comment->write($thread->id);
                    } catch (ValidationException $e) {
                        $page = 'write';
                    }
            default:
            throw new PageNotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }
}
