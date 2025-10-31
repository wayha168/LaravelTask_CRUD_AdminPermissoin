<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        return view('dashboard', compact('users', 'categories'));
    }
}
