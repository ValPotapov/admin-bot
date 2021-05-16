<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Salon;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:reports.index')->only('index');
        $this->middleware('can:reports.edit')->only('edit');
        $this->middleware('can:reports.show')->only('show');
        $this->middleware('can:reports.update')->only('update');
        $this->middleware('can:reports.store')->only('store');
        $this->middleware('can:reports.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->hasRole('salon_admin')){
            $reports = QueryBuilder::for(Report::class)
                ->with('salon')
                ->whereHas('salon', function (Builder  $builder){
                    $builder->where('user_id', Auth::id());
                })
                ->paginate()
                ->withQueryString();
        }else{
            $reports = QueryBuilder::for(Report::class)
                ->with('salon')
                ->paginate()
                ->withQueryString();
        }

        return Inertia::render('Reports/Index',compact('reports'))
            ->table(function (InertiaTable $table){
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
        if (Auth::user()->hasRole('salon_admin')){
            if (Auth::user()->date_index != date('Y-m-d')){
                abort(403);
            }
            $salons = Salon::where('user_id', Auth::id())->get();
        }else{
            $salons = Salon::all();
        }

        return Inertia::render('Reports/Create', compact('salons'));
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

        if (Auth::user()->hasRole('salon_admin')) {
            if (Auth::user()->date_index != date('Y-m-d')) {
                abort(403);
            }
        }

        $this->validate($request, [
            'number_calls' => 'required|numeric',
            'came' => 'required|numeric',
            'stayed' => 'required|numeric',
            'salon_id' => 'required|exists:salons,id',
            'date' => 'required|date|unique:reports',
        ]);

        Report::create([
            'number_calls' => $request->number_calls,
            'came' => $request->came,
            'stayed' => $request->stayed,
            'salon_id' => $request->salon_id,
            'date' => $request->date
        ]);

        if (Auth::user()->hasRole('salon_admin')){
            $user = User::find(Auth::id());
            $user->date_index = Carbon::parse(Auth::user()->date_index)->addDay();
            $user->save();
        }

        return Redirect::route('reports.index')->with('success', 'Отчет успешно создан');

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
    public function edit(Report $report)
    {
        //
        $salons = Salon::all();
        return Inertia::render('Reports/Edit', compact('salons', 'report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
        $this->validate($request, [
            'number_calls' => 'required|numeric',
            'came' => 'required|numeric',
            'stayed' => 'required|numeric',
            'salon_id' => 'required|exists:salons,id',
            'date' => 'required|date|unique:reports,id,'.$report->id,
        ]);

        $report->update($request->only( 'number_calls', 'came', 'stayed', 'salon_id', 'date'));

        return Redirect::route('reports.index')->with('success', 'Отчет успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
        $report->delete();
        return Redirect::route('reports.index')->with('success', 'Отчет успешно удален');
    }
}
