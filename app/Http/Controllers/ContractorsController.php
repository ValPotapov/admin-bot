<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\QueryBuilder;

class ContractorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:contractors.index')->only('index');
        $this->middleware('can:contractors.edit')->only('edit');
        $this->middleware('can:contractors.update')->only('update');
        $this->middleware('can:contractors.store')->only('store');
        $this->middleware('can:contractors.destroy')->only('destroy');
    }

    public function index()
    {
        $contractors = QueryBuilder::for(Contractor::class)
            ->paginate()
            ->withQueryString();

        return Inertia::render('Contractors/Index', [
            'contractors' => $contractors
        ])->table(function (InertiaTable $table) {
            $table->addColumn('name', 'Name');
            $table->addColumn('id', 'ID');
        });
    }

    public function create()
    {
        return Inertia::render('Contractors/Create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        Contractor::create($request->only('name'));

        return Redirect::route('contractors.index')->with('success', 'Контрагент успешно добавлен');
    }

    public function edit(int $id)
    {
        $contractor = Contractor::findOrFail($id);

        return Inertia::render('Contractors/Edit', compact('contractor'));
    }

    public function update(Request $request, int $id){
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $contractor = Contractor::findOrFail($id);

        $contractor->update(['name'=> $request->name]);
        $contractor->save();

        return Redirect::route('contractors.index')->with('success', 'Контрагент успешно обновлен');
    }

    public function destroy(int $id)
    {
        $contractor = Contractor::findOrFail($id);
        $contractor->delete();
        return Redirect::route('contractors.index')->with('success', 'Успешно удален');
    }
}
