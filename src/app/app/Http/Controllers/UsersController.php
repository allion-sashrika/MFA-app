<?php

namespace App\Http\Controllers;
 
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\UserRepository;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('user.index');
    }

    public function create()
    {
        $user = new User;

        return view('user.create')->with('user', $user);
    }

    public function store(UserRequest $request, UserRepository $repository)
    {
        $attributes = $request->all();

        $repository->saveUser(new User, $attributes);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('user.edit')->with('user', $user);
    }

    public function update(UserRequest $request, UserRepository $userRepository, User $user)
    {
        $user = $userRepository->saveUser($user, $request->all());

        return redirect()->route($user->save() ? 'users.index' : 'users.edit', compact('user'));
    }
}