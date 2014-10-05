<?php

class Comment extends Eloquent {

    /**
     * MASS ASSIGNMENT -------------------------------------------------------
     * define which attributes are mass assignable (for security)
     * we only want these 6 attributes able to be filled
     */
    protected $fillable = array('auction_id', 'user_id', 'date_created',
        'comment_title', 'comment_text');

    /**
     *  LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
     * if the plural of 'comment' isnt what we named our database table 
     * we have to define it
     */
    protected $table = 'comments';

    /**
     * Change default primary key
     * @var type string 
     */
    protected $primaryKey = 'comment_id';

    /**
     * Enable soft deletes for a model.
     * a 'deleted_at' timestamp  
     * @var type bool 
     */
//    protected $softDelete = true;

    /**
     *  DEFINE RELATIONSHIPS --------------------------------------------------
     * each Comment belongsTo one Auction
     * 
     * usage
     * $auc= Comment::find(2)->auction;
     */
    public function auction() {
        return $this->belongsTo('Auction');
    }

    /**
     *  DEFINE RELATIONSHIPS --------------------------------------------------
     *  When using the belongs_to method, the name of the relationship method 
     * should correspond to the foreign key (sans the _id). 
     * Since the foreign key is user_id, your relationship 
     * method should be named user!!!!
     */
    public function user() {
        return $this->belongsTo('User'); // user == creator
    }

    public function getAllComments() {

        return Comment::all();
        /*
         * //SQL DB query
         * return DB::select('select * from comments');
         */
    }

    public function getComment($id) {
        //return Comment::find($id);
        return Comment::findOrFail($id);
        /*
         * //SQL DB query
         * return DB::select('select * from comments where comment_id=?', array($id));
         */
    }

    public static $rules = array(
        'auction_id' => 'required|Numeric|min:1|exists:auctions,auction_id',
        'comment_title' => 'alphaNum|between:3,12',
        'comment_text' => 'required|min:3|max:2000',
    );

    public static function validateComment($input) {
        return Validator::make($input, self::$rules);
    }

    public static function createComment($input) {
        $validator = self::validateComment($input);

        if ($validator->passes()) {

            $comment = new Comment;
            if ($input['comment_title']) {
                $comment->comment_title = trim($input['comment_title']);
            }
            $comment->comment_text = trim($input['comment_text']);

            if ($input['auction_id']) {
                $comment->auction_id = $input['auction_id'];
            } else {
                App::error(function(NotAllowedException $exception, $code) {
                    return Redirect::to('/')
                                    ->with('error', 'field "auction_id" is missing!');
                });
            }

            $comment->user_id = Auth::user()->user_id;
            $comment->date_created = time(); //date('Y-m-d', time());
            $comment->save();

            return true;
        } else {
            return $validator;
        }
    }

}
