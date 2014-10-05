<?php

class UserController extends Controller {

    /**
     * Setup the layout used by the controller.
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    public function getIndex() {
        $users = User::all();
        return View::make('users')->with('users', $users);
    }
    
    public function myAuctions() {
        $auc = Illuminate\Support\Facades\Auth::user()->auctions;
        return View::make('my_auctions')->with('data', $auc);
    }

}
