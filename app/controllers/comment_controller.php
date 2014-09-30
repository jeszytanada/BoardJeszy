<?php
class CommentController extends AppController
{
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
        if (!is_logged()) {
            redirect(url('login/index'));
        }
        $comment  = Comment::get(Param::get('comment_id'));
        $username = $_SESSION['username'];
        $page     = Param::get('page_next','delete');

        switch($page) {
            case 'delete':
                break;

            case 'delete_end':
                $comment->id       = Param::get('comment_id');
                $comment->username = Param::get('username');
                $comment->body     = Param::get('body');
                $reply             = Param::get('reply');
                try {
                    if ($reply == 'yes') {
                        $comment->deleteComment($username, $reply);
                    } else {
                        redirect(url('thread/index'));
                    }
                } catch (ValidationException $e) {
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
