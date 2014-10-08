<?php
class User extends AppModel
{
    const MIN_USER_VAL = 1;
    const MAX_USER_VAL = 15;
    const MAX_PASSWORD = 16;
    const MIN_PASSWORD = 6;

    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', self::MIN_USER_VAL, self::MAX_USER_VAL,
            ),
            'format' => array(
                'is_valid_username', "Invalid Username"
            ),
        ),
        'password'=> array(
            'length' => array(
                'validate_between', self::MIN_PASSWORD, self::MAX_PASSWORD,
            ),
        ),
        'fname' => array(
            'length' => array(
                'validate_between', self::MIN_USER_VAL, self::MAX_USER_VAL,
            ),
            'format' => array(
                'is_valid_name', "Invalid First Name"
            ),
        ),
        'lname' => array(
            'length' => array(
                'validate_between', self::MIN_USER_VAL, self::MAX_USER_VAL,
            ),
            'format' => array(
                'is_valid_name', "Invalid Last Name"
            ),
        ),
        'email'=> array(
            'format' => array(
                'is_valid_email', "Invalid Email"
            ),
        ),
    );

    /** 
     * Check if username and password is matched
     * @return $user_info row
     */
    public function authenticate()
    {   
        if (!$this->validate()) {
            throw new ValidationException("Invalid Username/Password");
        }
        $db  = DB::conn();
        $row = $db->row('SELECT * FROM userinfo WHERE username = ? AND password = ?', array($this->username, $this->password));
        
        if (!$row){
            throw new UserNotFoundException("Username/Password is Incorrect");
        }  
        return new self($row);
    }

    /**
     * Validation filter_input(type, variable_name)
     * Checks if Username and Email exist
     * Else will be inserted to the database.
     */
    public function register()
    {
        if (!$this->validate()) {
            throw new ValidationException(notify('Error Found!', "error"));
        }
        $params = array(
            'username' => $this->username,
            'password' => $this->password,
            'fname'    => $this->fname,
            'lname'    => $this->lname,
            'email'    => $this->email
        );
        $db = DB::conn();
        $search_results = $db->row('SELECT username, email FROM userinfo WHERE username=? OR email=?', array($this->username,$this->email));
        
        if ($search_results) {
            throw new UserAlreadyExistsException(notify('Username / Email Already Exists',"error"));
        }
        $db->insert('userinfo',$params);
    }

    /** 
     * Get User Id 
     * @param username
     * @return user id
     */
    public static function getId($username)
    {
        $db = DB::conn();
        return $db->value('SELECT id FROM userinfo where username = ?', array($username));
    }
    
    /** 
     * Get User Info 
     * @param $user_id
     * @return userinfo row
     */
    public static function get($user_id) 
    {
        $db  = DB::conn();
        $row = $db->row('SELECT * FROM userinfo WHERE id = ?',array($user_id));
        
        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }
        return new self($row);
    }

    /** 
     * Before updating profile:
     * a separate function for checking username & email
     * @param $previous_info (username/email), $new_info (username/email),
     * @param $user_column (username/email)
     */
    public function checkUser($previous_info, $new_info, $user_column)
    {
        $db = DB::conn();
        if ($previous_info !=  $new_info) {
            $result = $db->row("SELECT $user_column FROM userinfo WHERE $user_column = ?", array($new_info));
            if ($result) {
                throw new UserAlreadyExistsException(notify('Username / Email Already Exists',"error"));
            }
        }
    }

    /** 
     * Profile edit / update, validate input
     * @param $user_id, $prev_username & $prev_email
     */
    public function update($user_id, $prev_username, $prev_email) 
    {
        if (!$this->validate()) {
            throw new ValidationException(notify('Error Found!', "error"));
        }
        self::checkUser($prev_username, $this->username, 'username');
        self::checkUser($prev_email, $this->email, 'email');

        try {
            $params = array(
                'username' => $this->username,
                'password' => $this->password,
                'fname'    => $this->fname,
                'lname'    => $this->lname,
                'email'    => $this->email
            );
            $db = DB::conn();
            $db->begin();
            $db->update('userinfo', $params, array('id' => $user_id));
            $db->update('comment', array('username' => $this->username), array('username' => $prev_username));
            $db->commit();
        } catch (ValidationException $e) {
            $db->rollback();
            throw $e;
        }
    }
}
