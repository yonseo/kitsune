<?php

// Login System
// 

class Controller_User extends Controller_Template
{

    //choose a template
    //public $template = 'template_frontend';

    public function action_index()
    {
        //redirect to homepage
        Response::redirect('user/login');
    }

    public function action_login()
    {
        if(Auth::check())
        {
            //user is already logged in
            //redirect to homepage
            Response::redirect('/');
        }

        if(Input::method() == 'POST' && Input::post('LOGIN'))
        {
            //user pressed LOGIN button
            //validate data
            $val = Validation::forge();
            $val->add_field('email', 'Your email', 'required|min_length[3]|max_length[50]');
            $val->add_field('password', 'Your password', 'required|min_length[3]|max_length[50]');
            if($val->run())
            {
                //check credentials
                $auth = Auth::instance();
                if($auth->login($val->validated('email'), $val->validated('password')))
                {
                    //login success
                    Session::set_flash('success', 'You have logged in');
                    //redirect to homepage
                    Response::redirect('/');
                }
                else 
                {
                	//credential ERROR. NO login.
	                Session::set_flash('error', 'Login Error');
	                //redirect to login page
	                Response::redirect('user/login');
                }
            }
            else
            {
                //login error
                Session::set_flash('error', 'Login Error');
                //redirect to login page
                Response::redirect('user/login');
            }
        }
        else
        {
            //take me to login page
            $data=[''];
            $this->template->title = 'Login';
            $this->template->footer = View::forge('footer');
            $this->template->content = View::forge('user/login', $data);

        }

    }

    public function action_logout()
    {
        //logout user
        
        if(Auth::check())
        {
            //user is logged in. Logout user
            Auth::logout();
            //logout flash message
            Session::set_flash('success', 'You are logged out');
            //redirect
            Response::redirect('/');
        }
        else
        {
            //user is NOT logged in. Redirect to homepage
            Response::redirect('/');
        }
    }

    public function action_register()
    {
        if(Auth::check())
        {
            //user is already logged in. DO NOT REGISTER!
            //redirect to homepage
            Response::redirect('/');
        }

        if(Input::method() == 'POST' && Input::post('REGISTER'))
        {
            //user pressed REGISTER button
            //validate data
            $val = Validation::forge();
            $val->add_field('username', 'Your username', 'required|min_length[3]|max_length[50]');
            $val->add_field('email', 'Your email', 'required|min_length[3]|max_length[50]');
            $val->add_field('password', 'Your password', 'required|min_length[3]|max_length[50]');
            $val->add_field('password_confirm', 'Confirm your password', 'required|min_length[3]|max_length[50]');
            if($val->run())
            {
                //create a new user
                $auth = Auth::instance();
                $create_user = $auth->create_user(
                    $val->validated('username'),
                    $val->validated('password'),
                    $val->validated('email'),
                    1,
                    ['username' => $val->validated('username')]
                );
                if($create_user)
                {
                    //new user created
                    Session::set_flash('success', 'User created');
                    $auth = Auth::instance();
                    if($auth->login($val->validated('email'), $val->validated('password')) | Auth::check())
                    {
                        //user logged IN
                        $current_user = Model_User::find_by_username(Auth::get_screen_name());
                        View::set_global('current_user', $current_user);
                        View::set_global('logged_in', $current_user);
                        //flash message
                        Session::set_flash('success', 'Welcome '. $current_user->username);
                        //take me to homepage
                        Response::redirect('/');
                    }
                    else
                    {
                        //new user created
                        //user is NOT logged in. Redirect to login page
                        Response::redirect('user/login');
                    }
                }
                else
                {
                    //ERROR when creating user
                    //flash message
                    Session::set_flash('error', 'There was an error creating a new user');
                }
            }
            else
            {
                //empty form or missing fields!
                //all fields must be filled
                Session::set_flash('error', 'All fields must be filled');
                //redirect to register page
                Response::redirect('user/register');
            }
            
        }
        else
        {
            //user did NOT press the REGISTER button
            //render the register form
            $data=[''];
            $this->template->title = 'Register';
            $this->template->footer = View::forge('footer');
            $this->template->content = View::forge('user/register', $data);
        }
    }

}