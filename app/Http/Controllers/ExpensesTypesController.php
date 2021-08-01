<?php

namespace App\Http\Controllers;

use App\Models\ExpensesTypes;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\QueryBuilder;

class ExpensesTypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:expensesTypes.index')->only('index');
        $this->middleware('can:expensesTypes.edit')->only('edit');
        $this->middleware('can:expensesTypes.update')->only('update');
        $this->middleware('can:expensesTypes.store')->only('store');
        $this->middleware('can:expensesTypes.destroy')->only('destroy');
    }

    public function index()
    {
        $expensesTypes = QueryBuilder::for(ExpensesTypes::class)
            ->paginate()
            ->withQueryString();

        return Inertia::render('ExpensesTypes/Index', [
            'expensesTypes' => $expensesTypes
        ])->table(function (InertiaTable $table) {
            $table->addColumn('name', 'Name');
            $table->addColumn('id', 'ID');
        });
    }

    public function create()
    {
        return Inertia::render('ExpensesTypes/Create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        ExpensesTypes::create($request->only('name'));

        return Redirect::route('expensesTypes.index')->with('success', 'Тип расходов успешно добавлен');
    }

    public function edit(int $id)
    {
        $expensesTypes = ExpensesTypes::findOrFail($id);

        return Inertia::render('ExpensesTypes/Edit', compact('expensesTypes'));
    }

    public function update(Request $request, int $id){
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $expensesTypes = ExpensesTypes::findOrFail($id);

        $expensesTypes->update(['name'=> $request->name]);
        $expensesTypes->save();

        return Redirect::route('expensesTypes.index')->with('success', 'Тип расходов успешно обновлен');
    }

    public function destroy(int $id)
    {
        $expensesTypes = ExpensesTypes::findOrFail($id);
        $expensesTypes->delete();
        return Redirect::route('expensesTypes.index')->with('success', 'Успешно удален');
    }
}
