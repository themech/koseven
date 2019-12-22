<?php

class Controller_Welcome extends Controller {

    public function action_login()
    {
        $status = Auth::instance()->login('newadmin' ,'somepass', true);
        if ($status) {
            $this->redirect('welcome/index');
        } else {
            $this->response->body('login failed!');
        }
    }

    public function action_logout()
    {
    	Auth::instance()->logout(TRUE);
    	$this->redirect('welcome/index');
    }

	public function action_index()
	{
		$user = null;
        try {
            $user = Auth::instance()->get_user();
        } catch (Exception $e) {
            echo $e."<br/>";
        }
        if (!$user) {
			$this->response->body('hello, anon user!<br/><a href="/welcome/login">login</a><br/><a href="/welcome/register">register user</a>');
        } else {
        	$this->response->body('hello, ' . $user->username . '.<br/><a href="/welcome/logout">logout</a>');
        }

	}

	public function action_register()
	{
		$user = ORM::factory('User');
        $user->where('username', '=', 'newadmin')->find();
        if (!$user->loaded()) {
            $user = ORM::factory('user');
            $user->username = 'newadmin';
            $user->password = 'somepass';
            $user->email = 'foor@bar.org';
            try{
                $user->save();
                $user->add('roles', ORM::factory('Role')->where('name', '=', 'login')->find());
                $user->save();
                $this->response->body('user created');
            }
            catch(ORM_Validation_Exception $e){
                var_dump($e->errors());
                die();
            }
        } else {
        	$this->response->body('user exists');

        }

	}

} // End Welcome
