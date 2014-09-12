<?php 
class ThreadController extends AppController
{
    /** Index Function:
    *** -Call Pagination
    *** -Count all threads
    **/
    public function index() {	
        if (!is_session()) {
            redirect('../');
        }   
	
	    $thread_count = Thread::threadCounter();
	    $pagination = Pagination($thread_count);
        $threads = Thread::getAll($pagination['max']);
	    $this->set(get_defined_vars());
    }

    /** View Function:
    *** -View all Threads as well as Comments
    **/
    public function view() {	
        $thread = Thread::get(Param::get('thread_id'));
	    $comments = $thread->getComments();
	    $this->set(get_defined_vars());
    }

    /** Write Function:
    *** -Get Thread thru id
    *** -Write comment to existing Thread
    **/
    public function write() {
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment;
        $page = Param::get('page_next','write');
        switch($page) {
	        case 'write':
	        break;

		    case 'write_end':
			    $comment->username = $_SESSION['username'];
			    $comment->body = Param::get('body');
			    try {
				    $thread->write($comment);
				    } catch (ValidationException $e) {
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


    /** Create Function:
    *** -Create new Thread with Comment
    **/
    public function create() {	
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

    /**Destroyinng session as to log out.**/
    function logout() {	
        session_destroy();
        redirect('../');
    }
}
