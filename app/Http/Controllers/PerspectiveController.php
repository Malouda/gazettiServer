<?php

namespace App\Http\Controllers;

use App\Perspective;
use Illuminate\Http\Request;

class PerspectiveController extends Controller
{
    public function getAllPerspectives(){

        return Perspective::all();
    }
}
