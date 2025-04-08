<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TurnosController extends Controller
{
    public function index()
    {
        return view('turnos.index');
    }
}