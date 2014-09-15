<?php
class LoginController extends AppController 
{ 
    /* Login controls.
    ** Username and password are
    ** taken from View and is pass to
    ** function AUTHORIZE to validate.
    ** $position = holds the position of the page.
    */
    public function index() {    
        $position = NULL;
        $user = new User();
        $user->username = Param::get('username');
        $user->password = Param::get('password');
        if (Param::get('username') && Param::get('password')) {
            try {
                $user_info = $user->authorize($user->username, $user->password);
                $_SESSION['username'] = $user_info->username;
                $_SESSION['password'] = $user_info->password;
                redirect(url('thread/index'));
            } catch (ValidationException $e) {
                $position = notify($e->getMessage(),"error");
            } catch (RecordNotFoundException $e) {
                $position = notify($e->getMessage(),"error");
            }
        } 
        $this->set(get_defined_vars());
    } 

    /* Register Function.
    ** $novalue = no value inputted.
    ** $pos   = holds the position.
    */
    public function register() {   
        $position = NULL;
        $add_username = Param::get('username');
        $add_password = Param::get('password');
        $add_name     = Param::get('name');
        $add_email    = Param::get('email');
        $user_info    = array(
                            'username' => $add_username,
                            'password' => $add_password,
                            'name'     => $add_name,
                            'email'    => $add_email
                        );
        $user = new User();
        $user->username = Param::get('username');
        $user->password = Param::get('password');
        $user->name     = Param::get('name');
        $user->email    = Param::get('email');
        $no_value = NULL;
        if ($_POST) {
          foreach ($user_info as $key => $value) { 
              if (!$value) {
                  $no_value++;
              } else {
                  $user_info['$key'] = $value;
               }
          }
          if (!$no_value) {
              try {
                  $pass = $user->register($user_info);
                  $position = notify("Registration Successful");
              } catch (UserAlreadyExistsException $e) {
                  $position = notify($e->getMessage(), "error");
              } catch(ValidationException $e) {
                  $position = notify($e->getMessage(), "error");
              } 
          }  
        }
        $this->set(get_defined_vars());
    }
}
