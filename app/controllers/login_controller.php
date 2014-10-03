<?php
class LoginController extends AppController 
{ 

    /** 
     * Username and password are
     * taken from View and is passed to
     * authenticate username & password.
     * $position = holds the position of the page.
     */

    public function index() 
    {    
        $position = null;
        $username = Param::get('username');
        $password = Param::get('password');
        $user = new User();
        if ($username) {
            try {
                $user->username = $username;
                $user->password = $password;
                $user_info = $user->authenticate();
                $_SESSION['username'] = $user_info->username;
                $_SESSION['password'] = $user_info->password;
                $_SESSION['id']       = $user_info->id;
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
                $position = notify("Registered Successfully");
            } catch (AppException $e) {
                $position = notify($e->getMessage(), "error");
            }      
        }
        $this->set(get_defined_vars());
    }
    
    /**
     * Updating profile, all info details can be retain
     * Sessions are initial value in view (previous details)
     * $position = holds the position of the page.
     */
    public function update() 
    {    
        if(!is_logged()) {
            redirect(url('login/index'));
        }
        $position = null;
        $user_id  = User::getId($_SESSION['username']);
        $user     = User::get($user_id);
        $_SESSION['fname'] = $user->fname;
        $_SESSION['lname'] = $user->lname;
        $_SESSION['email'] = $user->email;
        $prev_user         = $_SESSION['username'];
        $prev_email        = $_SESSION['email'];

        if ($user_id) {
            $user->username = Param::get('username');
            $user->password = Param::get('password');
            $user->fname    = Param::get('fname');
            $user->lname    = Param::get('lname');
            $user->email    = Param::get('email');
            $position = "";
            if($user->username) {
                try {
                    $user->update($user_id, $prev_user, $prev_email);
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
     * Redirect to login index
     */
    function logout() 
    { 
        session_destroy();
        redirect(url('login/index'));
    }
}

