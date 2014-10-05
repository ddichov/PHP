<?php

use \Illuminate\Support\Facades;

class AuctionController extends Controller {

    public function getAuction($id = null) {
        $auc_model = new Auction();
        if ($id == null) {
            $data = $auc_model->getAllAuctions();
            return View::make('auctions')->with('data', $data);
        } else {
            $data = $auc_model->getAuction($id);
            return View::make('bet_auction')->with('data', $data);
        }
    }

    public function getActualAuctions() {
        $auc_model = new Auction();
        $data = $auc_model->getActualAuctions();
        return View::make('auctions')->with('data', $data);
    }

    public function showAddAuction() {
        return View::make('add_auction');
    }

    public function addAuction() {

        $result = Auction::createAuction(Input::all());
        if ($result === true) {

            return Redirect::to('my/auction')
                            ->with('message', 'New auction created!');
        } else {

            return Redirect::to('add/auction')
                            ->withErrors($result)
                            ->withInput(Input::except('auction_desc'));
        }
    }

    public function commentAuction() {
        $result = Comment::createComment(Input::all());
        if ($result === true) {

            return Redirect::to('auction/' . Input::get('auction_id') . '/details')
                            ->with('message', 'New comment created!');
        } else {
            return Redirect::to('auction/' . Input::get('auction_id') . '/details')
                            ->withErrors($result)
                            ->withInput(Input::except('auction_desc'));
        }
    }

    public function voteAuction() {

        $result = Vote::createVote(Input::all());

        if ($result === true) {

            /*
             * Procedure ??? !!!!!
             * update auc voters
             * update auc stars
             */
            Auction::updateAuctionStars(Input::get('auction_id'));
            return Redirect::to('auction/' . Input::get('auction_id') . '/details')
                            ->with('message', 'New comment created!');
        } else {
            
            $errors = $result->messages()->toArray();
            if ($result->failed()['auction_id']['Unique']) {
                /*
                 * Change Error Message for ['auction_id'] unique rule:
                 * (default is: 'The auction id has already been taken.')
                 */
                $errors['auction_id'] = 
                        'You are not allowed to vote more than one time per auction!';
            }
            return Redirect::to('auction/' . Input::get('auction_id') . '/details')
                            ->withErrors($errors)
                            ->withInput(Input::except('auction_desc'));
        }
    }

    public function betAuction() {

        $result = Auction_price::bet(Input::all());
        if ($result === true) {

            return Redirect::action('AuctionController@getAuction')
                            ->with('message', 'New Bet created!');
        } else {

            return Redirect::to('auction/' . Input::get('auction_id'))
                            ->withErrors($result)
                            ->with('message', 'Bet Failed');
        }
    }

    public function showAuctionFullInfo($id) {
        $auc_model = new Auction();
        $auc = $auc_model->getAuction($id);
        $data['auction'] = array(
            'auction_id' => $auc->auction_id,
            'auction_title' => $auc->auction_title,
            'auction_desc' => $auc->auction_desc,
            'minimum_price' => $auc->minimum_price,
            'date_created' => date('Y-m-d', $auc->date_created),
            'date_end' => date('Y-m-d', $auc->date_end),
            'creator_username' => $auc->user->username,
            'voters' => $auc->voters,
            'stars' => $auc->stars,
        );
        $data['prices'] = [];
        // echo '<pre>'.print_r($auc->prices, true).'</pre>';
//        echo '<pre>'.print_r($auc->comments, true).'</pre>';

        foreach ($auc->prices as $v) {
            $data['prices'][] = array(
                'user_id' => $v->user_id,
                'username' => $v->user->username,
                'price_id' => $v->price_id,
                'price' => $v->price,
                'date_created' => date('Y-m-d', $v->date_created), // from timestamp
            );
        }

        if ($data['prices']) {
            usort($data['prices'], $this->build_desc_sorter('price'));
        }

        $data['comments'] = [];
        foreach ($auc->comments as $v) {
            $data['comments'][] = array(
                'user_id' => $v->user_id,
                'username' => $v->user->username,
                'comment_id' => $v->comment_id,
                'comment_title' => $v->comment_title,
                'comment_text' => $v->comment_text,
                'date_created' => date('Y-m-d', $v->date_created), // $v->date_created,
            );
        }
        if ($data['comments']) {
            usort($data['comments'], $this->build_desc_sorter('comment_id'));
        }
//        echo '<pre>'.print_r($data, true).'</pre>';
//        exit();

        return View::make('auction_details')->with('data', $data);
    }

    protected function build_sorter($key) {
        return function ($a, $b) use ($key) {
            return $a[$key] - $b[$key];
        };
    }

    protected function build_desc_sorter($key) {
        return function ($a, $b) use ($key) {
            return $b[$key] - $a[$key];
        };
    }

}
