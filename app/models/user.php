<?php
class User extends AppModel
{   
    const MIN_USER_VAL=1;
    const MAX_USER_VAL=15;
    const MAX_PASSWORD=16;
    const MIN_PASSWORD=6;

    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', self::MIN_USER_VAL,self::MAX_USER_VAL,
            ),
        ),
        'password'=> array(
            'length' => array(
                'validate_between', self::MIN_PASSWORD,self::MAX_PASSWORD,
            ),
        ),
         'name' => array(
            'length' => array(
                'validate_between', self::MIN_USER_VAL,self::MAX_USER_VAL,
            ),
        ),
        'email'=> array(
            "format" => array(
                'check_valid_email', "Invalid Email"
            ),
        ),
    );

    /** Authorize username and password if registered or matched. **/
    public function authorize($username, $password) {   
        if (!$this->validate()) {
            throw new ValidationException("Invalid Username/Password");
        }
        $db = DB::conn();
        $row = $db->row('SELECT * FROM userinfo WHERE username = ? AND password = ?',array($username, $password));
        if (!$row){
            throw new UserNotFoundException("User not found");
        }  
        return new self($row);
    }

    /* Function for Registration.
    ** Extract all values from array $user_info.
    ** Upon registering,checks if Username and Email is not yet used.
    ** Else will be inserted to the database.
    */
    public function register(array $user_info) {       
        extract($user_info);
        $params = array(
                      'username' => $username,
                      'password' => $password,
                      'name'     => $name,
                      'email'    => $email
                  );
        $this->username=$username;
        $this->password=$password;
        $this->name=$name;
        $this->email=$email;
                          
        if (!$this->validate()) {
            throw new ValidationException(notify('Error Found!', "error"));
        }

        $db = DB::conn();
        $query  = 'SELECT username, email FROM userinfo WHERE username=? OR email=?';
        $unique = array($username,$email);
        $search = $db->row($query,$unique);
        if ($search) {
            throw new UserAlreadyExistsException(notify('Username / Email Already Exists',"error"));
        }
        $row = $db->insert('userinfo',$params);    
    }  
}
 