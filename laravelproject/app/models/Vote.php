<?php

class Vote extends Eloquent {

    /**
     * MASS ASSIGNMENT -------------------------------------------------------
     * define which attributes are mass assignable (for security)
     * we only want these 6 attributes able to be filled
     */
    protected $fillable = array('auction_id', 'user_id', 'date_created', 'stars');

    /**
     *  LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
     * if the plural of 'auction' isnt what we named our database table 
     * we have to define it
     */
    protected $table = 'votes';

    /**
     * Change default primary key
     * @var type string 
     */
    protected $primaryKey = 'vote_id';

    /**
     * Enable soft deletes for a model.
     * a 'deleted_at' timestamp  
     * @var type bool 
     */
//    protected $softDelete = true;

    /**
     *  DEFINE RELATIONSHIPS --------------------------------------------------
     * each action HAS many user prices
     * 
     * usage
     * $auc= Category::find(2)->auctions;
     */
    public function auction() {
        return $this->belongsTo('Auction');
    }

    /**
     *  DEFINE RELATIONSHIPS --------------------------------------------------
     *  each action HAS one user == creator
     * When using the belongs_to method, the name of the relationship method 
     * should correspond to the foreign key (sans the _id). 
     * Since the foreign key is user_id, your relationship 
     * method should be named user!!!!
     */
    public function user() {
        return $this->belongsTo('User'); // user == creator
    }

    public function getAllVotes() {

        return Vote::all();
        /*
         * //SQL DB query
         * return DB::select('select * from votes');
         */
    }

    public function getVote($id) {
        //return Vote::find($id);
        return Vote::findOrFail($id);
    }

    public static $rules = array(
        'stars' => 'required|Numeric|between:0,6',
        'auction_id' => 'required|Numeric|exists:auctions,auction_id',
            // unique:table,column,except,idColumn
            // 'email' => 'unique:users,email_address,NULL,id,account_id,1'
            // only rows with an account_id of 1 would be included in the unique check.
    );

    public static function validateVote($input) {
        $rules = self::$rules;
        /*
         * unique by 2 columns:
         * auction_id and user_id
         */
        $rules['auction_id'] = $rules['auction_id'] . '|unique:votes,auction_id,NULL,id,user_id,' . Auth::user()->user_id;
        return Validator::make($input, $rules);
    }

    public static function createVote($input) {
        $validator = self::validateVote($input);

        if ($validator->passes()) {
            $vote = new Vote;
            $vote->auction_id = $input['auction_id'];
            $vote->stars = $input['stars'];
            $vote->user_id = Auth::user()->user_id;
            $vote->date_created = time();
            $vote->save();

            return true;
        }

        return $validator;
    }

//
//    public static function getPrices($id) {
//
////        $auc = Auction::find($id);
//        $auc = Auction::findOrFail($id);
//        return $auc->prices;
//    }
}
