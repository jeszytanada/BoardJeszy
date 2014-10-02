<?php
class CommentController extends AppController
{
    public function __construct($name) 
    { 
        parent::__construct($name);   
        if(is_logged() === false) { 
             redirect($controller = 'index'); 
        } 
    }

    /** 
     * Displays specific Thread and its containing Comments
     */
    public function view() 
    {    
        $thread = Thread::get(Param::get('thread_id'));
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
        $thread = Thread::get(Param::get('thread_id'));
        $page = Param::get('page_next','write');
        switch($page) {
            case 'write':
                break;

            case 'write_end':
                $comment->username = $_SESSION['username'];
                $comment->body     = Param::get('body');
                try {
                    $comment->write($thread->id);
                    } catch (ValidationException $a) {
                        $page = 'write';
                    }
                    break;            
            default:
                throw new PageNotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    /**
     * Delete Comment via Username
     */
    public function delete()
    {
        $position = null;
        $comment_id = Param::get('comment_id');
        $comment  = Comment::get(Param::get('comment_id'));
        $username = $_SESSION['username'];
        $page     = Param::get('page_next','delete');

        switch($page) {
            case 'delete':
                break;

            case 'delete_end':
                $reply = Param::get('reply');
                try {
                    if ($reply == 'yes') {
                        $comment->delete($username, $reply);
                    } else {
                        redirect(url('thread/index'));
                    }
                } catch (ValidationException $e) {
                    $position = notify($e->getMessage(), "error");
                    $page = 'delete';
                }
                break;
            default:
                throw new PageNotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }
}
