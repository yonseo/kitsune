<?php
class Model_User extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'username',
		'password',
		'group',
		'email',
		'last_login',
		'login_hash',
		//'remember_me',
		'profile_fields',
		'created_at',
		'updated_at'
	);
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('email', 'Email', 'required|max_length[255]');
		$val->add_field('username', 'Username', 'required|max_length[255]');
		$val->add_field('password', 'Password', 'required');
		return $val;
	}
	public function get_name()
	{
		$data = Auth::get_profile_fields();
		return $data['firstname'] . ' ' . $data['lastname'];
	}
	public function get_profile_field($field)
	{
		$data = Auth::get_profile_fields();
		if (isset($data[$field]))
			return $data[$field];
		else
			return null;
	}
	public static function getUserID($username)
    {
    	## get id from username ==##
    	
        // Check if username has data
        if ($username !== NULL && !empty($username))
        {
			$post = Model_User::find('first', [
           		'where' => [
                'username' => $username,
           		]
        	]);
        	$userid = $post->id;
			return $userid;
        }
        else
        {
            //no user id found
            return NULL;
        }
    }
    public static function getUsername($userid = NULL)
    {
    	## get username from id ==##
    	
        // Check if user id has data
        if (is_numeric($userid) && $userid !== NULL && !empty($userid))
        {
			$post = Model_User::find($userid);
        	$username = $post->username;
			return $username;
        }
        else
        {
            //no user id found
            return NULL;
        }
    }
	public static function isLoggedIN()
    {
        // Check if the current user is logged in
        if (\Auth::check() )
        {
            //get current username
			$user = Session::get('username');
			return $user;
        }
        else
        {
            //DENIED ACCESS. Kick Out
            Session::set_flash('error', 'Please Login');
            Response::redirect('user/login');
        }
    }

    public static function getAvatarFromUsername($username = NULL)
    {
        ##======================================================= get avatar image from username ==#
        if($username !== NULL && !empty($username))
        {
            // find user in db
            $post = Model_User::find('first', [
                'where' => [
                'username' => $username,
                ]
            ]);
            if($post)
            {
                return $post->avatar;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public static function getAvatarFromID($userid)
    {
        ##======================================================= get avatar image from username ==#
        if($userid !== NULL && !empty($userid))
        {
            // find user in db
            $post = Model_User::find('first', [
                'where' => [
                'id' => $userid,
                ]
            ]);
            if($post)
            {
                return $post->avatar;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
	
    public static function doesUserExist($username)
    {
        ## check if user exists in db. return true or false. ==##
        
        // Check if the current user is logged in
        $post = Model_User::find('first', [
            'where' => [
            'username' => $username,
            ]
        ]);
        if($post)
        {
            return true;
        }
        else
        {
            return false;
        }

    }
	

}
