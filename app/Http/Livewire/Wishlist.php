<?php

namespace App\Http\Livewire;
use Auth;
use DB;

use Livewire\Component;

class Wishlist extends Component
{
    public function render()
    {
        $data = 0;
        if (Auth::user()) {
            $data = DB::table('wishlists')->whereUserId(Auth::user()->id)->count();
            return view('livewire.wishlist', ['data'=>$data]);
        }
        return view('livewire.wishlist', ['data'=>$data]);
    }
}
