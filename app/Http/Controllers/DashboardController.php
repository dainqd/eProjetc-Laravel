<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;

class DashboardController extends Controller
{
    public function index()
    {
        return match (auth()->user()->role) {
            UserRole::Teacher, UserRole::Student, UserRole::Parent => redirect()->route('classes.ongoing'),
            UserRole::Admin => redirect()->route('feedbacks.index'),
        };
    }

    public function contact()
    {
        return view('pages.contact-us');
    }
}
