<?php 
class ThreadController extends AppController
{
    /** 
    * Call class Pagination to show number of pages
    * Count all existing threads
    */
    public function index() 
    {   
        if (!is_logged()) {
            redirect(url('login/index'));
        }   
        
        $thread_count = Thread::count();
        $pagination = Pagination($thread_count);
        $threads = Thread::getAll($pagination['max']);
        $this->set(get_defined_vars());
    }

    /** 
    * Create new Thread and should be with Comment/s
    */
    public function create() 
    {  
        $thread = new Thread;
        $comment = new Comment;
        $page = Param::get('page_next','create');

        switch($page) {
            case 'create':
                break;

            case 'create_end':
                $thread->title = Param::get('title');
                $comment->username = $_SESSION['username'];
                $comment->body = Param::get('body');
                try {
                    $thread->create($comment);
                } catch (ValidationException $e) {
                    $page = 'create';
                }
            default:
            throw new PageNotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    /**
    * Destroying session and logging out.
    */
    function logout() 
    { 
        session_destroy();
        redirect('../');
    }
}
