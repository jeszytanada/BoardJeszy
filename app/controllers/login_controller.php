<?php
class LoginController extends AppController 
{ 
    /** 
     * Username and password are
     * taken from View and is passed to
     * authenticate and to validate the username & password.
     * $position = holds the position of the page.
     */
    public function index() 
    {    
        $position = NULL;
        $username = Param::get('username');
        $password = Param::get('password');
        $user = new User();
        if ($username && $password) {
            try {
                $user->username = $username;
                $user->password = $password;
                $user_info = $user->authenticate();
                $_SESSION['username'] = $user_info->username;
                $_SESSION['password'] = $user_info->password;
                $_SESSION['id'] = $user_info->id;
                redirect(url('thread/index'));
            } catch (AppException $e) {
                $position = notify($e->getMessage(),"error");
            }
        } 
        $this->set(get_defined_vars());
    } 

    /**
     * Gets the user information and use to register
     * $position = holds the position of the page.
     */
    public function register() 
    {   
        $position = null;
        $user = new User();
        $user->username = Param::get('username');
        $user->password = Param::get('password');
        $user->fname    = Param::get('fname');
        $user->lname    = Param::get('lname');
        $user->email    = Param::get('email');
        if($user->username) {
            try {
                $user->register();
                $position = notify("Registration Successful");
                } catch (AppException $e) {
                    $position = notify($e->getMessage(), "error");
                }      
        }
        $this->set(get_defined_vars());
    }

    public function update() 
    {
        if (!is_logged()) {
            redirect(url('login/index'));
        }   
        $position = null;
        $prev_user = $_SESSION['username'];
        $user_id = User::getUserId($_SESSION['username']);
        $user = User::get($user_id);

        if ($user_id) {
            $user->username = Param::get('username');
            $user->password = Param::get('password');
            $user->fname    = Param::get('fname');
            $user->lname    = Param::get('lname');
            $user->email    = Param::get('email');
            $position = "";
            if($user->username) {
                try {
                    $user->updateProfile($user_id, $prev_user);
                    $position = notify("Edit / Update Success");
                    $_SESSION['username'] = $user->username;
                } catch (AppException $e) {
                    $position = notify($e->getMessage(), 'error');
                }
              
            }
        } $this->set(get_defined_vars()); 
    }
    
    /**
     * Destroying session and logging out.
     */
    function logout() 
    { 
        session_destroy();
        redirect(url('login/index'));
    }
}
