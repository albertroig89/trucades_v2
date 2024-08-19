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
    public function index(Request $request): View|Factory|Application
    {
        $title = 'Trucades';
        $users = User::all();
        $phones = Phone::all();
        $techId = Department::where('title', 'Tecnic')->value('id');
        $admId = Department::where('title', 'Administracio')->value('id');
        $globId = Department::where('title', 'Global')->value('id');
        $nStat = Stat::where('title', 'Normal')->value('id');
        $uStat = Stat::where('title', 'Urgent')->value('id');
        $pStat = Stat::where('title', 'Pendent')->value('id');

        $globalId = User::where('name', 'Global')->value('id');

        $allcalls = false;

        // Lógica para determinar el usuario actual y llamadas relevantes
        if (!empty($request->get('user_id')) && $request->get('user_id') == "100") {
            $allcalls = true;
            $userid = auth()->id();
            $user = User::find($userid);
        } elseif (empty($request->get('user_id'))) {
            $userid = auth()->id();
            $user = User::find($userid);
        } else {
            $userid = $request->get('user_id');
            $user = User::find($userid);
        }

        // Determinar las llamadas basadas en el departamento del usuario y el ID de usuario
        if (empty($request->get('user_id')) && auth()->user()->department_id === $techId) {
            $calls = Call::whereIn('user_id', [auth()->id(), $globalId])
                ->orderBy('user_id', 'DESC')
                ->orderBy('stat_id')
                ->orderBy('created_at', 'DESC')
                ->paginate(50);
        } elseif (empty($request->get('user_id')) && auth()->user()->department_id === $admId) {
            $calls = Call::orderBy('created_at', 'DESC')->paginate(20);
            $allcalls = true;
        } elseif (empty($request->get('user_id'))) {
            $calls = Call::where('user_id', auth()->id())
                ->orderBy('stat_id')
                ->orderBy('created_at', 'DESC')
                ->paginate(50);
        } elseif ($request->get('user_id') == "100") {
            $calls = Call::orderBy('created_at', 'DESC')->paginate(100);
        } else {
            $calls = Call::where('user_id', $request->get('user_id'))
                ->orderBy('stat_id')
                ->orderBy('created_at', 'DESC')
                ->paginate(50);
        }

        return view('dashboard', compact('title', 'calls', 'users', 'phones', 'techId', 'globId', 'nStat', 'uStat', 'pStat', 'user', 'allcalls'));
    }
}
//namespace App\Http\Controllers;
//
//use App\Models\Call;
//use App\Models\Department;
//use App\Models\Phone;
//use App\Models\Stat;
//use App\Models\User;
//use Illuminate\Http\Request;
//
//class HomeController extends Controller
//{
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
//
//    /**
//     * Show the application dashboard.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index(Request $request)
//    {
//        $title = 'Llamadas';
//        $users = User::all();
//        $phones = Phone::all();
//
//        $departments = Department::whereIn('title', ['Tecnic', 'Administracio', 'Global'])->pluck('id', 'title');
//        $stats = Stat::whereIn('title', ['Normal', 'Urgent', 'Pendent'])->pluck('id', 'title');
//
//        $techId = $departments['Tecnic'] ?? null;
//        $admId = $departments['Administracio'] ?? null;
//        $globId = $departments['Global'] ?? null;
//
//        $nStat = $stats['Normal'] ?? null;
//        $uStat = $stats['Urgent'] ?? null;
//        $pStat = $stats['Pendent'] ?? null;
//
//        $globalId = User::where('name', 'Global')->value('id');
//
//        $userId = $request->get('user_id', auth()->id());
//        $allcalls = $request->get('user_id') == "100";
//
//        $query = Call::query();
//
//        if ($allcalls) {
//            $query->orderBy('created_at', 'DESC')->paginate(100);
//        } else {
//            if (auth()->user()->department_id === $techId) {
//                $query->whereIn('user_id', [auth()->id(), $globalId]);
//            } elseif (auth()->user()->department_id === $admId) {
//                $query->orderBy('created_at', 'DESC')->paginate(20);
//                $allcalls = true;
//            } else {
//                $query->where('user_id', auth()->id());
//            }
//
//            if ($request->get('user_id') != "100") {
//                $query->where('user_id', $userId);
//            }
//
//            $query->orderBy('stat_id')
//                ->orderBy('created_at', 'DESC');
//
//            $calls = $query->paginate(50);
//        }
//
//        $usuari = User::find($userId);
//
//        return view('dashboard', compact('title', 'calls', 'users', 'phones', 'techId', 'globId', 'nStat', 'uStat', 'pStat', 'usuari', 'allcalls'));
//    }
//}
