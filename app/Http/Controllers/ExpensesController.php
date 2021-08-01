<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Expenses;
use App\Models\ExpensesTypes;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\QueryBuilder;

class ExpensesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:expenses.index')->only('index');
        $this->middleware('can:expenses.edit')->only('edit');
        $this->middleware('can:expenses.update')->only('update');
        $this->middleware('can:expenses.store')->only('store');
        $this->middleware('can:expenses.destroy')->only('destroy');
    }

    public function index()
    {
        $expenses = QueryBuilder::for(Expenses::class)
            ->with('type')
            ->with('contractor')
            ->orderByDesc('id')
            ->paginate()
            ->withQueryString();

        return Inertia::render('Expenses/Index', [
            'expenses' => $expenses
        ])->table(function (InertiaTable $table) {
            $table->addColumn('id', 'ID');
            $table->addColumn('date', 'Date');
            $table->addColumn('type.name', 'Type');
            $table->addColumn('contractor.name', 'Contractor');
            $table->addColumn('sum', 'Sum');
            $table->addColumn('comment', 'Comment');
        });
    }

    public function create()
    {
        $contractors = Contractor::all()->toArray();
        $expensesTypes = ExpensesTypes::all()->toArray();

        return Inertia::render('Expenses/Create',compact('contractors','expensesTypes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'contractor' => 'required|exists:contractors,id',
            'type' => 'required|exists:expenses_types,id',
            'sum' => 'required|numeric',
            'comment' => 'required|string'
        ]);

        $contractor = Contractor::find($request->contractor);
        $expenseType = ExpensesTypes::find($request->type);

        $expense = new Expenses();
        $expense->date = $request->date;
        $expense->sum = $request->sum;
        $expense->comment = $request->comment;
        $expense->contractor()->associate($contractor);
        $expense->type()->associate($expenseType);
        $expense->save();

        return Redirect::route('expenses.index')->with('success', 'Расход успешно добавлен');
    }

    public function edit(int $id)
    {
        $contractors = Contractor::all()->toArray();
        $expensesTypes = ExpensesTypes::all()->toArray();

        $expense = Expenses::with(['type','contractor'])->findOrFail($id);

        return Inertia::render('Expenses/Edit', compact('expense','contractors','expensesTypes'));
    }

    public function update(Request $request, int $id){
        $this->validate($request, [
            'date' => 'required|date',
            'contractor' => 'required|exists:contractors,id',
            'type' => 'required|exists:expenses_types,id',
            'sum' => 'required|numeric',
            'comment' => 'required|string'
        ]);

        $contractor = Contractor::find($request->contractor);
        $expenseType = ExpensesTypes::find($request->type);

        $expense = Expenses::findOrFail($id);
        $expense->date = $request->date;
        $expense->sum = $request->sum;
        $expense->comment = $request->comment;
        $expense->contractor()->associate($contractor);
        $expense->type()->associate($expenseType);
        $expense->save();

        return Redirect::route('expenses.index')->with('success', 'Расход успешно обновлен');
    }

    public function destroy(int $id)
    {
        $Expenses = Expenses::findOrFail($id);
        $Expenses->delete();
        return Redirect::route('expenses.index')->with('success', 'Успешно удален');
    }
}
