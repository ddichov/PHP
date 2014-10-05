<?php

class Category extends Eloquent {

    /**
     * MASS ASSIGNMENT -------------------------------------------------------
     * define which attributes are mass assignable (for security)
     * we only want these 6 attributes able to be filled
     */
    protected $fillable = array('user_id', 'parent_id',
        'date_created', 'name', 'description');

    /**
     *  LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
     * if the plural of 'auction' isnt what we named our database table 
     * we have to define it
     */
    protected $table = 'categories';

    /**
     * Change default primary key
     * @var type string 
     */
    protected $primaryKey = 'category_id';

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
    public function auctions() {
        return $this->hasMany('Auction'); // this matches the Eloquent model
    }

    /**
     *  DEFINE RELATIONSHIPS --------------------------------------------------
     *  each Category HAS one user == creator
     * When using the belongs_to method, the name of the relationship method 
     * should correspond to the foreign key (sans the _id). 
     * Since the foreign key is user_id, your relationship 
     * method should be named user!!!!
     */
    public function user() {
        return $this->belongsTo('User'); // column 'user_id'
//        return $this->belongsTo('User', 'user_id'); // column 'user_id'
    }

    public function getAllCategories() {

        return Category::all();
        /*
         * //SQL DB query
         * return DB::select('select * from auctions');
         */
    }

    public function getCategoryAuctions($id) {
        return Auction::where('category_id', '=', $id)->get();
    }

    public function categoryExist($id) {                // NOT necessary
        return Category::find($id)->count();
//        return Category::findOrFail($id);
    }

    public function getCategory($id) {
        //return Category::find($id);
        return Category::findOrFail($id);
        /*
         * //SQL DB query
         * return DB::select('select * from auctions where auction_id=?', array($id));
         */
    }

    public static $rules = array(
        'name' => 'required|alphaNum|between:3,12',
        'description' => 'min:3|max:2000',
        'date_end' => 'required|date',
        'parent_id' => 'Numeric|min:1|max:200|exists:categories,category_id'
    );

    public static function validateCategory($input) {
        return Validator::make($input, self::$rules);
    }

    public static function createCategory($input) {
        $validator = self::validateCategory($input);

        if ($validator->passes()) {

            $cat = new Category;
            $cat->name = trim($input['name']);
            $cat->minimum_price = $input['minimum_price'];

            if ($input['parent_id']) {
                $id = $input['parent_id'];
                if ($this->categoryExist($id)) {     // NOT necessary
                    $cat->parent_id = $id;
                }
            }

            if ($input['description']) {
                $cat->description = $input['description'];
            }

            $cat->user_id = Auth::user()->user_id;
            $cat->date_created = time();
            $cat->save();

            return true;
        } else {
            return $validator;
        }
    }

    public static function getParentCategory($id) {
        $cat = Auction::findOrFail($id);
        $parent = Auction::findOrFail($cat->parent_id);
        return $parent;
    }

}
