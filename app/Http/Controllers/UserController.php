<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra una lista de usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        $title = 'Usuarios';

        return view('users.index', compact('title', 'users'));
    }

    /**
     * Muestra los detalles de un usuario específico.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $title = 'Detalles de Usuarios';

        return view('users.show', compact('title', 'user'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title = 'Nuevo usuario';
        $departments = Department::all();

        return view('users.create', compact('title', 'departments'));
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $title = 'Editar usuario';
        $departments = Department::all();

        return view('users.edit', compact('title', 'departments', 'user'));
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $request)
    {
        $request->createUser();
        return redirect()->route('users.index');
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index');
    }

    /**
     * Elimina un usuario de la base de datos.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
