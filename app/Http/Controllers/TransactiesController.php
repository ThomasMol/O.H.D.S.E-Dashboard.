<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transactie;
use App\SErekening;

class TransactiesController extends Controller
{
    public function index(){

        return view('transacties/transacties');
    }
}
