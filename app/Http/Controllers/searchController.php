<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class searchController extends Controller
{

public function searchResult(Request $request) {
    $search = $request->search;
    $result = User::where('name','LIKE','%'.$search.'%')->get();

    return view('search_result')->with(compact('result'));
}
}
