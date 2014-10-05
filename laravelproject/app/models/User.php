<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'users';

    /**
     * Change default primary key
     */
    protected $primaryKey = 'user_id';
    // public $timestamps = false; //

    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     */
    protected $hidden = array('password');
    
    /**
     * Enable soft deletes for a model.
     * a 'deleted_at' timestamp  
     * @var type bool 
     */
//    protected $softDelete = true;

    public static $rules = array(
        'name' => 'required|min:3|max:15',
        'username' => 'required|min:3|max:15',
        'email' => 'required|email|Unique:users',
        'password' => 'required|alphaNum|confirmed|between:3,12',
        'password_confirmation' => 'required|alpha_num|between:3,12'
    );

    public static function validateUser($input) {
        return Validator::make($input, self::$rules);
    }

    /**
     * Create new User.
     * @return mixed (TRUE or errors)
     */
    public static function createUser($input) {

        $validator = self::validateUser($input);

        if ($validator->passes()) {

            $user = new User;
            $user->name = trim($input['name']);
            $user->username = trim($input['username']);
            $user->email = trim($input['email']);
            $user->password = Hash::make($input['password']);
            $user->save();

            /**
             * // OR
             * 
             *  User::create(array(
             *     'name' => trim($input['name']),
             *     'username' => trim($input['username']),
             *     'email' => trim($input['email']),                
             *     'password' => Hash::make($input['password']),
             *  ));
             */
            return true;
        } else {
            return $validator;
        }
    }

    /**
     * DEFINE RELATIONSHIPS --------------------------------------------------
     * each user (CREATOR) has many auctions 
     * @return array of Auction ($user->auctions = array)
     */
    public function auctions() {
        return $this->hasMany('Auction');
    }

    /**
     *  DEFINE RELATIONSHIPS --------------------------------------------------
     * each action HAS many auc prices (bets)
     * 
     * usage:
     * $auc_prices= User::find(2)->prices;
     */
    public function prices() {
        return $this->hasMany('Auction_price');
    }

    /**
     * Get the unique identifier for the user.
     * @return mixed
     */
    public function getAuthIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     * @return string
     */
    public function getAuthPassword() {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     * @return string
     */
    public function getReminderEmail() {
        return $this->email;
    }

    // abstract methods implementation =====================
    public function getRememberToken() {
        return $this->remember_token;
    }

    public function setRememberToken($value) {
        $this->remember_token = $value;
    }

    public function getRememberTokenName() {
        return 'remember_token';
    }

}
