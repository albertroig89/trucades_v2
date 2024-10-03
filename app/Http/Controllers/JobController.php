<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateJobRequest;
use App\Models\Call;
use App\Models\Client;
use App\Models\HistJob;
use App\Models\HistJob2;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\CreateJobFromCallRequest;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
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
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'DESC')->paginate(50);
        $users = User::all();
        $title = 'Trabajos';

        return view('jobs.index', compact('title', 'jobs', 'users'));
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
     * Muestra el formulario para editar un trabajo existente.
     *
     * @param Job $job
     * @return \Illuminate\View\View
     */
    public function edit(Job $job)
    {
        $clients = Client::all();
        $users = User::all();

        return view('jobs.edit', compact('job', 'clients', 'users'));
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
        $data = $request->validated();

        $inittime = Carbon::createFromFormat('d-m-Y H:i', $data['inittime']);
        $endtime = Carbon::createFromFormat('d-m-Y H:i', $data['endtime']);

        $data['inittime'] = $inittime;
        $data['endtime'] = $endtime;
        $data['totalmin'] = $endtime->diffInMinutes($inittime);

        $job->update($data);

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
        $title = "Historic de feines";

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

