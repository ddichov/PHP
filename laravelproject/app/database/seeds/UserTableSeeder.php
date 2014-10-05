<?php

/**
 * to run seeding:
 * php artisan db:seed
 */
class UserTableSeeder extends Seeder {

    public function run() {
        DB::table('users')->delete();
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1;');
        DB::table('categories')->delete();
        DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1;');
        DB::table('auctions')->delete();
        DB::statement('ALTER TABLE auctions AUTO_INCREMENT = 1;');
        DB::table('auction_prices')->delete();
        DB::statement('ALTER TABLE auction_prices AUTO_INCREMENT = 1;');
        DB::table('comments')->delete();
        DB::statement('ALTER TABLE comments AUTO_INCREMENT = 1;');



        /**
         * ========================================================
         * ================ //    seed users   //  ================
         * ========================================================
         */
        $user1 = User::create(array(
                    'name' => 'Antony BBB',
                    'username' => 'aaa',
                    'email' => 'aaa@aaa.aaa',
                    'password' => Hash::make('qwerty'),
        ));

        $user2 = User::create(array(
                    'name' => 'Bob BBB',
                    'username' => 'bbb',
                    'email' => 'bbb@bbb.bbb',
                    'password' => Hash::make('qwerty'),
        ));

        $user3 = User::create(array(
                    'name' => 'Jhon BBB',
                    'username' => 'bbb',
                    'email' => 'ccc@ccc.ccc',
                    'password' => Hash::make('qwerty'),
        ));

        $this->command->info('Users created!');


        /**
         * ========================================================
         * ================ // seed categiries  // ================
         * ========================================================
         */
        $cat1 = Category::create(array(
                    'name' => 'Computers',
                    'description' => 'Category Computers',
                    'date_created' => strtotime('2014-06-2'),
                    'parent_id' => null,
                        // 'user_id' => $user1->user_id,
        ));
        // link categiry to user ---------------------
        $cat1->user()->associate($user1);
        $cat1->save();

        $cat2 = Category::create(array(
                    'name' => 'Laptops',
                    'description' => 'SubCategory Laptops',
                    'date_created' => strtotime('2014-06-3'),
                    'parent_id' => $cat1->category_id,
                    'user_id' => $user1->user_id,
        ));

        $cat11 = Category::create(array(
                    'name' => 'Routers',
                    'description' => 'SubCategory Routers',
                    'date_created' => strtotime('2014-06-25'),
                    'parent_id' => $cat1->category_id,
                    'user_id' => $user1->user_id,
        ));

        $cat21 = Category::create(array(
                    'name' => 'Tennis',
                    'description' => 'Category Tennis',
                    'date_created' => strtotime('2014-06-26'),
                    'parent_id' => null,
                    'user_id' => $user2->user_id,
        ));

        $this->command->info('Categiries created!');


        /**
         * ========================================================
         * ================ //  seed auctions   // ================
         * ========================================================
         */
        $auc1 = Auction::create(array(
                    'auction_title' => 'Lilliput 7"',
                    'auction_desc' => 'Lilliput 7" Industrial Computer with WinCE OS',
                    'minimum_price' => 10.5,
                    'date_end' => strtotime('2014-06-21'),
                    'date_created' => strtotime('2014-06-26'),
                    'category_id' => $cat1->category_id,
                    'user_id' => $user1->user_id,
        ));


        $auc2 = Auction::create(array(
                    'auction_title' => 'Carbon Tennis Racquet',
                    'auction_desc' => 'very good',
                    'minimum_price' => 200.30,
                    'date_end' => strtotime('2014-07-28'),
                    'date_created' => strtotime('2014-06-30'),
                    'category_id' => $cat21->category_id,
                    'user_id' => $user2->user_id,
        ));

        $auc3 = Auction::create(array(
                    'auction_title' => 'Tennis balls',
                    'auction_desc' => 'Custom printed tennis balls',
                    'minimum_price' => 59.99,
                    'date_end' => strtotime('2014-08-28'),
                    'date_created' => strtotime('2014-06-30'),
                        // 'category_id' => 4,
                        //  'user_id' => '2',
        ));
        // link auction to categiry and users ---------------------
        $auc3->category()->associate($cat21);
        $auc3->user()->associate($user2);
        $auc3->save();

        $this->command->info('Auctions created!');

        
        /**
         * ========================================================
         * ================ //  seed comments   // ================
         * ========================================================
         */
        
        $comment1 = Comment::create(array(
                    'comment_text' => 'comment1 for auc 2.',
                    'comment_title' => 'title c1 a2',
                    'date_created' => strtotime('2014-06-30'),
                    'user_id' => $user1->user_id,
                    'auction_id' => $auc2->auction_id,
        ));
        $this->command->info('comment 1 created!');

        $comment2 = Comment::create(array(
                    'comment_text' => 'comment2 for auc 1.',
                    'comment_title' => 'title c2 a1',
                    'date_created' => strtotime('2014-06-30'),
                    'user_id' => $user2->user_id,
                        // 'auction_id' => $auc1->auction_id,
        ));

        /**
         * save( object )
         * @var type object / model 
         * 
         * automaticly set ==>> $comment2.auction_id = $auc1->auction_id
         */
        $auc1->comments()->save($comment2);         // save( object )
        $this->command->info('comment 2 created!');

        $comments_arr = array(
            array('comment_text' => 'Comment 1 for auc 3.',
                'comment_title' => 'title 1',
                'date_created' => strtotime('2014-06-28'),
                'user_id' => $user1->user_id,
                'auction_id' => $auc3->auction_id, // Important!!!
            ),
            array('comment_text' => 'comment 2 for auc 3.',
                'comment_title' => 'title 2',
                'date_created' => strtotime('2014-06-3'),
                'user_id' => $user1->user_id,
                'auction_id' => $auc3->auction_id, // Important!!!
            ),
        );

        /**
         * insert (@var)    
         * @var type array 
         * 
         * ~= update
         * Does NOT  set automaticly==>> $commentX.auction_id = $auc1->auction_id
         * 1 Auction has_many Comments
         */
        $auc3->comments()->insert($comments_arr);    // insert (array) 

        $this->command->info('all comments created!');
        
        
         /**
         * ========================================================
         * ================ //    seed votes    // ================
         * ========================================================
         */
        $vote1 = Vote::create(array(
                    'stars' => 2,
                    'date_created' => strtotime('2014-06-30'),
                    'user_id' => $user1->user_id,
                    'auction_id' => $auc2->auction_id,
        ));
        $vote2 = Vote::create(array(
                    'stars' => 3,
                    'date_created' =>strtotime('2014-06-30'),
                    'user_id' => $user3->user_id,
                    'auction_id' => $auc2->auction_id,
        ));
        $vote3 = Vote::create(array(
                    'stars' => 3,
                    'date_created' => strtotime('2014-06-30'),
                    'user_id' => $user3->user_id,
                    'auction_id' => $auc3->auction_id,
        ));
        $this->command->info('All votes created!');
        
        
         /**
         * ========================================================
         * ================ //    seed Prices   // ================
         * ========================================================
         */
        $timestamp = strtotime('2014-06-29');
        
        $price1 = Auction_price::create(array(
                    'price' => 209.99,
                    'date_created' => $timestamp,
                    'user_id' => $user1->user_id,
                    'auction_id' => $auc2->auction_id,
        ));
        $price2 = Auction_price::create(array(
                    'price' => 202.22,
                    'date_created' => $timestamp,
                    'user_id' => $user3->user_id,
                    'auction_id' => $auc2->auction_id,
        ));
        $price3 = Auction_price::create(array(
                    'price' => 60.22,
                    'date_created' => strtotime('2014-06-30'),
                    'user_id' => $user3->user_id,
                    'auction_id' => $auc3->auction_id,
        ));
        
        $price4 = Auction_price::create(array(
                    'price' => 12.22,
                    'date_created' => strtotime('2014-06-30'),
                    'user_id' => $user3->user_id,
                    'auction_id' => $auc1->auction_id,
        ));
        
         $this->command->info('All prices created!');
    }

}
