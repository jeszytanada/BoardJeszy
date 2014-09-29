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
            'format' => array(
                'check_username_format', "Invalid Username"
            ),
        ),
        'password'=> array(
            'length' => array(
                'validate_between', self::MIN_PASSWORD,self::MAX_PASSWORD,
            ),
        ),
        'fname' => array(
            'length' => array(
                'validate_between', self::MIN_USER_VAL,self::MAX_USER_VAL,
            ),
        ),
        'lname' => array(
            'length' => array(
                'validate_between', self::MIN_USER_VAL,self::MAX_USER_VAL,
            ),
        ),
        'email'=> array(
            'format' => array(
                'check_valid_email', "Invalid Email"
            ),
        ),
    );

    /** 
     *Check if username and password is registered or matched in the database.
     */
    public function authenticate()
    {   
        if (!$this->validate()) {
            throw new ValidationException("Invalid Username/Password");
        }
        $db = DB::conn();
        $row = $db->row('SELECT * FROM userinfo WHERE username = ? AND password = ?', array($this->username, $this->password));
        if (!$row){
            throw new UserNotFoundException("User not found");
        }  
        return new self($row);
    }

    /**
     * Extract all values from array $user_info.
     * Upon registering,checks if Username and Email is not yet used.
     * Else will be inserted to the database.
     */
    public function register()
    {   
        $params = array(
            'username' => $this->username,
            'password' => $this->password,
            'fname'    => $this->fname,
            'lname'    => $this->lname,
            'email'    => $this->email
        );
        if (!$this->validate()) {
            throw new ValidationException(notify('Error Found!', "error"));
        }

        $db = DB::conn();
        $search_results = $db->row('SELECT username, email FROM userinfo WHERE username=? OR email=?', 
            array($this->username,$this->email));
        if ($search_results) {
            throw new UserAlreadyExistsException(notify('Username / Email Already Exists',"error"));
        }
        $db->insert('userinfo',$params);    
    }  

    public static function getUserId($username)
    {
        $db = DB::conn();
        $user_id = $db->value('SELECT id FROM userinfo where username = ?', array($username));
        return $user_id;
    }
}
 
