<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaperController extends Controller
{
    //


    public function render_browse_papers(){


        return view('papers.index');
    }

    public function render_detail_page(Request $request , $id){

        return view('papers.details');
    }

    public function render_cart(){
        return view('papers.cart');
    }

    public function render_checkout(){
        return view('papers.checkout');
    }
}
