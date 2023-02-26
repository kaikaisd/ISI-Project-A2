<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchasingController extends Controller
{
    public function index()
    {
        return view('purchasing.index');
    }

    public function formStep()
    {
        return view('purchasing.step');
    }

    public function store(){
        
    }
}
