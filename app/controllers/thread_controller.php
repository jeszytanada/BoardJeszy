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
        $paginate = new Pagination;
        $page = $paginate->getPage($thread_count);
        $pagination_links = $paginate->rangeRows($page['pagenum'], $page['last_page']);
        $threads = Thread::getAll($pagination_links['max']);
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
                break;
            default:
            throw new PageNotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    /**
     * Rating a Thread, gets Thread id
     * and rate it from 0, 1, or 2
     */    
    public function rate()
    {
        $thread = new Thread;
        $thread = Thread::get(Param::get('thread_id'));
        $page = Param::get('page_next','rate');

        switch($page) {
            case 'rate':
                break;

            case 'rate_end':
                $thread->title = Param::get('title');
                $thread->id = Param::get('thread_id');
                $star_count = Param::get('rating');
                try {
                    $thread->getRate($star_count);
                } catch (ValidationException $e) {
                    $page = 'rate';
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
     * Destroying session and logging out.
     */
    function logout() 
    { 
        session_destroy();
        redirect('../');
    }
}
