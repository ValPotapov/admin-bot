<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Salon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Testing\Fluent\Concerns\Has;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users.index')->only('index');
        $this->middleware('can:users.edit')->only('edit');
        $this->middleware('can:users.show')->only('show');
        $this->middleware('can:users.update')->only('update');
        $this->middleware('can:users.store')->only('store');
        $this->middleware('can:users.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = QueryBuilder::for(User::class)
            ->with('roles')
            ->paginate()
            ->withQueryString();

        return Inertia::render('Users/Index', [
            'users' => $users
        ])->table(function (InertiaTable $table){
            $table->addColumn('name', 'Name');
            $table->addColumn('id', 'ID');
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::all();
        return Inertia::render('Users/Create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required|exists:roles,name'
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role);

        return Redirect::route('users.index')->with('success', 'Пользователь успешно создан');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        if (empty($user)){
            abort(404);
        }
        $roles = Role::all();
        $user->load('roles');
        return Inertia::render('Users/Edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $this->validate($request, [
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,id,'.$user->id,
            'password' => 'nullable|confirmed',
            'role' => 'required|exists:roles,name'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $user->syncRoles([$request->role]);

        return Redirect::route('users.index')->with('success', 'Пользователь успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();

        return Redirect::route('users.index')->with('success', 'Пользователь успешно удален');
    }
}
