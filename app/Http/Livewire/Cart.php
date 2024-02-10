<?php

namespace App\Http\Livewire;
use Auth;
use DB;
use Session;

use Livewire\Component;

class Cart extends Component
{
    public function render()
    {
        $data = 0;
        if (Auth::user()) {
            $data = DB::table('carts')->whereUserId(Auth::user()->id)->count();
            return view('livewire.cart', ['data'=>$data]);
        } else {
            $data = DB::table('carts')->whereUserId(session()->getId())->count();
            return view('livewire.cart', ['data'=>$data]);
        }
        return view('livewire.cart', ['data'=>$data]);
    }
}
