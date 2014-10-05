<?php

class HomeController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
     */

    /*
     *  Adding In the CSRF Before Filter
     */
    public function __construct() {
        // parent::__construct();
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function showWelcome() {
        return View::make('hello');
    }

    public function showLogin() {
        return View::make('login');
    }

    public function doLogin() {
        $rules = array(
            'email' => str_replace('|Unique:users', '|exists:users,email', User::$rules['email']),
            'password' => User::$rules['password_confirmation'],
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

            return Redirect::to('login')
                            ->withErrors($validator)
                            ->withInput(Input::except('password'));
        } else {

            $userdata = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );

            if (Auth::attempt($userdata, TRUE)) {
                // validation successful!
                return Redirect::to('auction');
            } else {
                // validation not successful, send back to form	
                return Redirect::to('login')->withInput(Input::except('password'));
            }
        }
    }

    public function logout() {
        Auth::logout();
        return Redirect::to('login');
    }

    public function showRegistration() {
        return View::make('registration');
    }

    public function doRegistration() {

        $result = User::createUser(Input::all());

        if ($result === true) {

            return Redirect::to('login')
                            ->with('message', 'Thanks for registering!');
        } else {

            return Redirect::to('registration')
                            ->withErrors($result)
                            ->withInput(Input::except('password'));
        }
    }
}
