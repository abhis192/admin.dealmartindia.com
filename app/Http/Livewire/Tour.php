<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
use App\Models\Whitelist;

class Tour extends Component
{
    public function render()
    {
        return view('livewire.tour');
    }

    public function addToWishList($tourId) {
        if (Auth::check()) {
            if (Whitelist::whereUserId(Auth::user()->id)->wherePackageId($tourId)->exists()) {
                // code...
                return false;
            } else {
                $data['user_id']=Auth::user()->id;
                $data['package_id']=$tourId;
                Whitelist::create($data);
            }
        } else {
            session()->flash('error','Please Login first');
            return false;
        }
    }
}
