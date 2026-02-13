<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotesController extends Controller
{
    //

    public function render_notes_page(){
        return view('notes.index');
    }


}
