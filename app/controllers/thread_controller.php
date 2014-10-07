<?php 
class ThreadController extends AppController
{
    /**
     * Constructor to always check user
     * logged in status
     */
    public function __construct($name) 
    { 
        parent::__construct($name);   
        if(is_logged_in() === false) { 
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
     * $username is not same with session username
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
                try {
                    $thread->id        = Param::get('thread_id');
                    $thread->user_id   = User::getId($_SESSION['username']);
                    $thread->title     = Param::get('title');
                    $comment->username = $username;
                    $comment->body     = Param::get('body');
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
        $page   = Param::get('page_next','rate');
        switch($page) {
            case 'rate':
                break;

            case 'rate_end':
                try {
                    $star_count = Param::get('rating');
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

    /**
     * Deletion of thread by owner
     */
    public function delete()
    {
        $position = "";
        $thread   = Thread::get(Param::get('thread_id'));
        $user_id  = User::getId($_SESSION['username']);
        $page     = Param::get('page_next','delete');

        switch($page) {
            case 'delete':
                break;

            case 'delete_end':
                try {
                    $reply = Param::get('reply');
                    if ($reply == 'no') {
                        redirect(url('thread/index'));  
                    } 
                    $thread->delete($user_id);
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

    /**
     * Edit title of thread by owner
     */
    public function update() 
    {    
        
        $thread   = Thread::get(Param::get('thread_id'));
        $user_id  = User::getId($_SESSION['username']);
        $thread->title = Param::get('title');
        $position = "";
        if($thread->title) {
            try {
                $thread->update($user_id);
                $position = notify("Update Success");
            } catch (AppException $e) {
                $position = notify($e->getMessage(), 'error');
            }
        }
        $this->set(get_defined_vars()); 
    }
}
