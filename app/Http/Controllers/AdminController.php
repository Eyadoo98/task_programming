<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function admin():View
    {
        $allUsers = User::all();
        return view('admin.dashboard', compact('allUsers'));
    }
}
