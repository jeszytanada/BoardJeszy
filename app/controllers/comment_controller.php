<?php
class CommentController extends AppController
{
    /**
     * Constructor to always check user
     * logged in status
     */
    public function __construct($name) 
    { 
        parent::__construct($name);   
        if (is_logged_in() === false) { 
             redirect($controller = 'index');
        }
    }

    /** 
     * Displays specific Thread and its containing Comment/s
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
        $thread  = Thread::get(Param::get('thread_id'));
        $page    = Param::get('page_next','write');
        
        switch($page) {
            case 'write':
                break;

            case 'write_end':
                try {
                    $comment->username = $_SESSION['username'];
                    $comment->body     = Param::get('body');
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
     * Delete Comment using Username
     */
    public function delete()
    {
        $comment_id = Param::get('comment_id');
        $comment    = Comment::get(Param::get('comment_id'));
        $page       = Param::get('page_next','delete');
        $status     = "";
        
        switch($page) {
            case 'delete':
                break;

            case 'delete_end':
                try {
                    if (Param::get('reply') == 'no') {
                        redirect(url('thread/index'));
                    } else {
                        $comment->delete($_SESSION['username']);
                    }
                } catch (ValidationException $e) {
                    $status = notify($e->getMessage(), "error");
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
