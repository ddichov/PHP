<?php

class Auction extends Eloquent {

    /**
     * MASS ASSIGNMENT -------------------------------------------------------
     * define which attributes are mass assignable (for security)
     * we only want these 6 attributes able to be filled
     */
    protected $fillable = array('user_id', 'date_created', 'minimum_price',
        'date_end', 'auction_title', 'auction_desc', 'category_id',
        'votes', 'stars');

    /**
     *  LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
     * if the plural of 'auction' isnt what we named our database table 
     * we have to define it
     */
    protected $table = 'auctions';

    /**
     * Change default primary key
     * @var type string 
     */
    protected $primaryKey = 'auction_id';

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
     * $auc= Auction::find(2)->prices;
     */
    public function prices() {
        return $this->hasMany('Auction_price'); // this matches the Eloquent model
    }

    /**
     *  DEFINE RELATIONSHIPS >>------------------------------------------------
     *  each action HAS one user == creator
     * When using the belongs_to method, the name of the relationship method 
     * should correspond to the foreign key (sans the _id). 
     * Since the foreign key is user_id, the relationship 
     * method should be named user!!!!
     */
    public function user() {
        return $this->belongsTo('User'); // 
        // return $this->belongsTo('User', 'user_id'); // column 'user_id'
    }

    public function category() {
        return $this->belongsTo('Category'); // 1 auction belongsTo 1 category
    }

    public function comments() {
        return $this->hasMany('Comment');
    }

    public function votes() {
        return $this->hasMany('Vote');
    }

    /*
     *  DEFINE RELATIONSHIPS END <<-------------------------------------------
     */

    public function getAllAuctions() {

        return Auction::all();
        /*
         * //SQL DB query
         * return DB::select('select * from auctions');
         */
    }

    public function getActualAuctions() {
        //$today = date("Y-m-d");
        return Auction::where('date_end', '>=', time())->get();
    }

    public function getAuction($id) {
        //return Auction::find($id);
        return Auction::findOrFail($id);
        /*
         * //SQL DB query
         * return DB::select('select * from auctions where auction_id=?', array($id));
         */
    }

    public static $rules = array(
        'auction_title' => 'required|between:5,12', //'|alphaNum',
        'minimum_price' => 'required|Numeric|min:3|max:10000',
        'date_end' => 'required|date',
    );

    public static function validateAuction($input) {
        $rules = self::$rules;
        $rules['date_end'] = 'required|date|after:' . date('Y-m-d', time());
        return Validator::make($input, $rules);
    }

    public static function createAuction($input) {
        $validator = self::validateAuction($input);

        if ($validator->passes()) {

            $auction = new Auction;
            $auction->auction_title = trim($input['auction_title']);
            $auction->minimum_price = $input['minimum_price'];
            $auction->date_end = strtotime($input['date_end']);
            if ($input['auction_desc']) {
                $auction->auction_desc = $input['auction_desc'];
            }

            $auction->user_id = Auth::user()->user_id;
            $auction->date_created = time(); // == timestamp // date('Y-m-d', time());
            $auction->save();

            return true;
        } else {
            return $validator;
        }
    }

    public static function getPrices($id) {
//        $auc = Auction::find($id);
        $auc = Auction::findOrFail($id);
        return $auc->prices;
    }

    public static function updateAuctionStars($id) {
        $auc = Auction::findOrFail($id);
        $v = $auc->votes;
        $voters = 0;
        $stars = 0.0;

        foreach ($v as $value) {
            $voters++;
            $stars+=$value->stars;
        }

        $auc->voters = $voters;
        $auc->stars = $stars / $voters;
        $auc->save();

        return true;
    }

    public static function getAuctionComments($auction_id) {
        $auc = Auction::findOrFail($auction_id);
        return $auc->comments;
    }

}
