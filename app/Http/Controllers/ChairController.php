<?php

namespace App\Http\Controllers;

use App\Chair;
use Illuminate\Http\Request;

class ChairController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateChair($id)
    {
        return !Chair::where('id', $id)->first()->reservation_id?'true':'false';
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChairs()
    {
        return Chair::orderBy('id', 'ASC')->get();
    }
}
