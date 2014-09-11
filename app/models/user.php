<?php
class User extends AppModel{   
    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', 1,15,
            ),
        ),

        'password'=> array(
            'length' => array(
                'validate_between', 6,15,
            ),
        ),

         'name' => array(
            'length' => array(
                'validate_between', 1,15,
            ),
        ),

        'email'=> array(
            "format" => array(
                'check_valid_email', "Invalid Email"
            ),
        ),
    );

/** Authorize username and password if registered or matched. **/
public function authorize($username, $password){	
    if (!$this->validate()){
        throw new ValidationException("Invalid Username/Password");
    }
    $db=DB::conn();
    $row =$db->row('SELECT * FROM userinfo WHERE username = ? AND password = ?',array($username, $password));
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
public function register(array $user_info){       
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
                          
    if (!$this->validate()){
        throw new ValidationException(notify('Error Found!', "error"));
    }

    $db = DB::conn();
    $query  = 'SELECT username, email FROM userinfo WHERE username=? OR email=?';
    $unique = array($username,$email);
    $search = $db->row($query,$unique);
    if($search){
        throw new UserAlreadyExistsException(notify('Username / Email Already Exists',"error"));
    }
    $row = $db->insert('userinfo',$params);    
}  
}
 