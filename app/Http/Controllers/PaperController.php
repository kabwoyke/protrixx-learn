<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    //


    public function render_browse_papers(){
      
        return view('papers.index');
    }

    public function render_detail_page(Request $request , $id){

        return view('papers.details');
    }
}
