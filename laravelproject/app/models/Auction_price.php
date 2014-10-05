<?php

class Auction_price extends Eloquent {

    /**
     *  MASS ASSIGNMENT -------------------------------------------------------
     * define which attributes are mass assignable (for security)
     * we only want these 6 attributes able to be filled
     */
    protected $fillable = array('user_id', 'auction_id', 'price',
        'date_created');
    
    /**
     * Enable soft deletes for a model.
     * a 'deleted_at' timestamp  
     * @var type bool 
     */
//    protected $softDelete = true;

    /**
     *  DEFINE RELATIONSHIPS --------------------------------------------------
     * When using the belongs_to method, the name of the relationship method 
     * should correspond to the foreign key (sans the _id). 
     * Since the foreign key is user_id, your relationship 
     * method should be named user!!!!
     */
    public function user() {
        return $this->belongsTo('User');
    }
    
    /**
     *  DEFINE RELATIONSHIPS --------------------------------------------------
     */
    public function auction() {
        return $this->belongsTo('Auction');
    }

    public static $rules = array(
        'auction_id' => 'exists:auctions,auction_id',
        'price' => 'required|Numeric|min:3|max:2000',
    );

    public static function validateAuction_price($input) {

        $min_price = Auction::find($input['auction_id'])->minimum_price;

        $rules2 = self::$rules;
        $rules2['price'] = 'required|Numeric|min:' . $min_price . '|max:2000';

        return Validator::make($input, $rules2);
    }

    public static function bet($input) {

        $validator = self::validateAuction_price($input);

        if ($validator->passes()) {

            $auction = new Auction_price();
            $auction->price = $input['price'];
            $auction->auction_id = $input['auction_id'];
            $auction->user_id = Auth::user()->user_id;
            $auction->date_created = time();//date('Y-m-d', time());
            $auction->save();

            return true;
        } else {
            return $validator;
        }
    }

}
