<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Department;
use App\Models\Phone;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return View|Factory|Application
     */
//    public function index(Request $request): View|Factory|Application
//    {
//
//    }

}

