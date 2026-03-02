<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevController extends Controller
{
    public function index()
    {
        $developer = User::where('id', 1)->first();
        return view('admin.developer', compact('developer'));
    }
}
