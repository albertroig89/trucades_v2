<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateJobRequest;
use App\Models\Call;
use App\Models\Client;
use App\Models\Department;
use App\Models\HistJob;
use App\Models\HistJob2;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\CreateJobFromCallRequest;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra una lista de trabajos.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Obtener la preferencia de vista desde la solicitud
        $viewType = $request->get('viewType', 'index'); // 'index' por defecto

//        $jobs = Job::orderBy('created_at', 'DESC')->paginate(50);
        $users = User::all();
        $title = 'Trabajos';

        $techId = Department::where('title', 'Tecnico')->value('id');
        $admId = Department::where('title', 'Administración')->value('id');
        $globId = Department::where('title', 'Global')->value('id');

        $globalId = User::where('name', 'Global')->value('id');
        $alljobs = false;

        // Lógica para determinar el usuario actual y trabajos relevantes
        if (!empty($request->get('user_id')) && $request->get('user_id') == "100") {
            $alljobs = true;
            $userid = auth()->id();
            $user = User::find($userid);
        } elseif (empty($request->get('user_id'))) {
            $userid = auth()->id();
            $user = User::find($userid);
        } else {
            $userid = $request->get('user_id');
            $user = User::find($userid);
        }


        // Determinar los trabajos basados en el departamento del usuario y el ID de usuario
        if (empty($request->get('user_id')) && auth()->user()->department_id === $techId) {
            $jobs = Job::whereIn('user_id', [auth()->id(), $globalId])
                ->orderBy('user_id', 'DESC')
                ->orderBy('created_at', 'DESC')
                ->paginate(50);
        } elseif (empty($request->get('user_id')) && auth()->user()->department_id === $admId) {
            $jobs = Job::orderBy('created_at', 'DESC')->paginate(20);
            $alljobs = true;
        } elseif (empty($request->get('user_id'))) {
            $jobs = Job::where('user_id', auth()->id())
                ->orderBy('created_at', 'DESC')
                ->paginate(50);
        } elseif ($request->get('user_id') == "100") {
            $jobs = Job::orderBy('created_at', 'DESC')->paginate(100);
        } else {
            $jobs = Job::where('user_id', $request->get('user_id'))
                ->orderBy('created_at', 'DESC')
                ->paginate(50);
        }
        return view("jobs.$viewType", compact('title', 'jobs', 'users', 'alljobs', 'user', 'globId', 'techId'));
    }

    /**
     * Muestra un trabajo específico.
     *
     * @param Job $job
     * @return \Illuminate\View\View
     */
    public function show(Job $job)
    {
        $title = 'Trabajo';
        return view('jobs.show', compact('title', 'job'));
    }

    /**
     * Muestra el formulario para crear un nuevo trabajo.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title = 'Nuevo trabajo';
        $clients = Client::all();
        $users = User::all();

        return view('jobs.create', compact('title', 'clients', 'users'));
    }


    /**
     * Metodo para mostrar el formulario de creación de trabajo desde una llamada
     *
     * @return \Illuminate\View\View
     */
    public function jobfromcallform(Call $call)
    {
        $clients = Client::all();
        $title = 'Nuevo trabajo';

        return view('calls.jobfromcall', compact('call', 'clients', 'title'));
    }

    /**
     * Muestra el formulario para editar un trabajo existente.
     *
     * @param Job $job
     * @return \Illuminate\View\View
     */
    public function edit(Job $job)
    {
        $title = 'Editar trabajo';
        $clients = Client::all();
        $users = User::all();

        return view('jobs.edit', compact('title', 'job', 'clients', 'users'));
    }

    /**
     * Almacena un nuevo trabajo en la base de datos.
     *
     * @param CreateJobRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateJobRequest $request)
    {
        $request->createJob();
        return redirect()->route('jobs.index');
    }

    /**
     * Crea un trabajo a partir de una llamada.
     *
     * @param CreateJobFromCallRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function jobfromcall(CreateJobFromCallRequest $request)
    {
        $calls = Call::all();

        if (empty($request->delete)) {
            $request->createJobFromCall();
        } else {
            $request->createJobFromCall();
            Call::find($request->delete)?->delete();
        }

        return redirect()->route('jobs.index');
    }

    /**
     * Actualiza un trabajo existente.
     *
     * @param Job $job
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Job $job, UpdateJobRequest $request)
    {
        $request->updateJob($job);
        return redirect()->route('jobs.index');
    }


    /**
     * Muestra el historial de trabajos.
     *
     * @return \Illuminate\View\View
     */
    public function histjob()
    {
        $histjobs = HistJob::orderBy('created_at', 'DESC')->paginate(50);
        $title = "Historico de trabajos";

        return view('jobs.histjobs', compact('title', 'histjobs'));
    }

    /**
     * Muestra el historial de trabajos ocultos.
     *
     * @return \Illuminate\View\View
     */
    public function histjob2()
    {
        $histjobs = HistJob2::orderBy('created_at', 'DESC')->paginate(50);
        $title = "Historico de trabajos oculto";

        return view('jobs.histjobs2', compact('title', 'histjobs'));
    }

    /**
     * Muestra el contador de trabajos.
     *
     * @return \Illuminate\View\View
     */
    public function count()
    {
        $jobs = Job::all();
        $users = User::all();
        $histjobs = HistJob::all();
        $histjobs2 = HistJob2::all();
        $title = 'Contador';

        return view('jobs.count', compact('title', 'jobs', 'users', 'histjobs', 'histjobs2'));
    }

    /**
     * Mueve un trabajo al historial de trabajos.
     *
     * @param HistJob $histjob
     * @return \Illuminate\Http\RedirectResponse
     */
    public function histdestroy(HistJob $histjob)
    {
        HistJob2::create([
            'username' => $histjob->username,
            'job' => $histjob->job,
            'inittime' => $histjob->inittime,
            'endtime' => $histjob->endtime,
            'totalmin' => $histjob->totalmin,
            'clientname' => $histjob->clientname,
        ]);

        $histjob->delete();
        return redirect()->route('jobs.histjobs');
    }

    /**
     * Elimina un trabajo y lo mueve al historial de trabajos.
     *
     * @param Job $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Job $job)
    {
        HistJob::create([
            'username' => $job->user->name,
            'job' => $job->job,
            'inittime' => $job->inittime,
            'endtime' => $job->endtime,
            'totalmin' => $job->totalmin,
            'clientname' => $job->clientname,
        ]);

        $job->delete();
        return redirect()->route('jobs.index');
    }
}

