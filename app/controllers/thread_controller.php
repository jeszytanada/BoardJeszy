<?php 
class ThreadController extends AppController
{
    public function __construct($name) 
    { 
        parent::__construct($name);   
        if(is_logged() === false) { 
             redirect($controller = 'index'); 
        } 
    }

    /** 
     * Call class Pagination to show number of pages
     * Count all existing threads
     */
    public function index() 
    {   
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
        $thread   = new Thread;
        $comment  = new Comment;
        $username = Param::get('username');
        $page     = Param::get('page_next','create');
        switch($page) {
            case 'create':
                break;
                
            case 'create_end':
                $thread->id        = Param::get('thread_id');
                $thread->user_id   = User::getId($_SESSION['username']);
                $thread->title     = Param::get('title');
                $comment->username = $username;
                $comment->body     = Param::get('body');
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
        $thread = Thread::get(Param::get('thread_id'));
        $page = Param::get('page_next','rate');
        switch($page) {
            case 'rate':
                break;

            case 'rate_end':
                $star_count = Param::get('rating');
                try {
                    $thread->increaseRate($star_count);
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

    public function delete()
    {
        $position = null;
        $thread  = Thread::get(Param::get('thread_id'));
        $user_id = User::getId($_SESSION['username']);
        $page    = Param::get('page_next','delete');

        switch($page) {
            case 'delete':
                break;

            case 'delete_end':
                $reply = Param::get('reply');
                try {
                    if ($reply == 'yes') {
                        $thread->delete($user_id, $reply);
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
