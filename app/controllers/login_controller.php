<?php
class LoginController extends AppController 
{ 
    /** 
     * Username and password are
     * taken from View and is pass to
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
                redirect(url('thread/index'));
            } catch (AppException $e) {
                $position = notify($e->getMessage(),"error");
            }
        } 
        $this->set(get_defined_vars());
    } 

    /**
     * $no_value = no value inputted.
     * $position   = holds the position of the page.
     */
    public function register() 
    {   
        $position = NULL;
        $user = new User();
        $user->username = Param::get('username');
        $user->password = Param::get('password');
        $user->name     = Param::get('name');
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
}
