<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Department;
use App\Models\Phone;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Llamadas';
        $users = User::all();
        $phones = Phone::all();

        $departments = Department::whereIn('title', ['Tecnic', 'Administracio', 'Global'])->pluck('id', 'title');
        $stats = Stat::whereIn('title', ['Normal', 'Urgent', 'Pendent'])->pluck('id', 'title');

        $techId = $departments['Tecnic'] ?? null;
        $admId = $departments['Administracio'] ?? null;
        $globId = $departments['Global'] ?? null;

        $nStat = $stats['Normal'] ?? null;
        $uStat = $stats['Urgent'] ?? null;
        $pStat = $stats['Pendent'] ?? null;

        $globalId = User::where('name', 'Global')->value('id');

        $userId = $request->get('user_id', auth()->id());
        $allcalls = $request->get('user_id') == "100";

        $query = Call::query();

        if ($allcalls) {
            $query->orderBy('created_at', 'DESC')->paginate(100);
        } else {
            if (auth()->user()->department_id === $techId) {
                $query->whereIn('user_id', [auth()->id(), $globalId]);
            } elseif (auth()->user()->department_id === $admId) {
                $query->orderBy('created_at', 'DESC')->paginate(20);
                $allcalls = true;
            } else {
                $query->where('user_id', auth()->id());
            }

            if ($request->get('user_id') != "100") {
                $query->where('user_id', $userId);
            }

            $query->orderBy('stat_id')
                ->orderBy('created_at', 'DESC');

            $calls = $query->paginate(50);
        }

        $usuari = User::find($userId);

        return view('dashboard', compact('title', 'calls', 'users', 'phones', 'techId', 'globId', 'nStat', 'uStat', 'pStat', 'usuari', 'allcalls'));
    }
}
