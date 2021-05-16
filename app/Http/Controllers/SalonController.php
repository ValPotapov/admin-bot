<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Salon;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class SalonController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('can:salons.index')->only('index');
        $this->middleware('can:salons.edit')->only('edit');
        $this->middleware('can:salons.show')->only('show');
        $this->middleware('can:salons.update')->only('update');
        $this->middleware('can:salons.store')->only('store');
        $this->middleware('can:salons.destroy')->only('destroy');
    }

    public function index()
    {
        $count = Report::select('number_calls')->sum('number_calls');

        if (Auth::user()->hasRole('salon_admin')){
            $salons = QueryBuilder::for(Salon::class)
                ->with('reports')
                ->where('user_id', Auth::id())
                ->paginate()
                ->withQueryString();
        }else{
            $salons = QueryBuilder::for(Salon::class)
                ->with('reports')
                ->paginate()
                ->withQueryString();
        }

        foreach ($salons as $key => $salon){
            $tempCount = $salon->reports->sum('number_calls');
            $salons[$key]->percent = round($tempCount * 100 / $count).'%';
        }

        return Inertia::render('Salons/Index', [
            'salons' => $salons
        ])->table(function (InertiaTable $table){
            $table->addColumn('name', 'Name');
            $table->addColumn('id', 'ID');
        });
    }

    public function show(Salon $salon, Request  $request)
    {
        $reports = $salon->reports;
        $minData = $reports->sortBy('created_at')->first()->created_at;

        if ($request->get('type') == 'months'){
            if (!Auth::user()->can('salons.show.months')){
                abort(403);
            }
            $type = 'months';
            $date = $this->generateDate($minData, 'MMMM YYYY', 'months');
            $count = $reports->sum('number_calls');
            foreach ($date as $key => $value){

                $tempCount = $reports->filter(function ($report)use ($value) {
                    return $report->created_at->year == $value['year'] && $report->created_at->month == $value['month'];
                });

                $value = ['value' => round($tempCount->sum('number_calls') * 100 / $count).'%'];
                $date[$key] =  array_merge($date[$key], $value);
            }
        }else{
            $type = 'days';
            $date = $this->generateDate($minData, 'DD MMMM YYYY', 'days');

            foreach ($date as $key => $value){
                $tempCount = $reports->filter(function ($report)use ($value) {
                    return $report->created_at->format('d.m.Y') == $value['date'];
                });

                $value = ['value' => $tempCount->sum('number_calls')];
                $date[$key] =  array_merge($date[$key], $value);
            }
        }

        return Inertia::render('Salons/Show',
            compact('date', 'salon', 'type'));
    }

    public function create()
    {
        $users = User::role('salon_admin')->get();
        return Inertia::render('Salons/Create', compact('users'));
    }

    public function store(Request  $request)
    {
       $this->validate($request,[
           'name' => 'required|string|max:255',
           'user_id' => 'required|exists:users,id'
       ]);

        Salon::create($request->all());

        return Redirect::route('salons.index')->with('success', 'Салон успешно создан');
    }

    public function edit(Request $request,Salon $salon){

        $users = User::role('salon_admin')->get();

        return Inertia::render('Salons/Edit',
        compact('salon', 'users'));
    }

    public function update(Request $request,Salon $salon){

        $salon->update($request->only('name', 'user_id'));

        return Redirect::route('salons.index')->with('success', 'Салон успешно обновлен');
    }

    public function destroy(Request $request,Salon $salon){

        $salon->delete();

        return Redirect::route('salons.index')->with('success', 'Салон успешно удален');
    }

    private function generateDate(Carbon $min, $format, $type)
    {
        $results = [];
        $i = 0;
        while (true){
            $date = $min->isoFormat($format);

            $results[] = [
                'label' => $date,
                'month' => $min->format('m'),
                'year' => $min->format('Y'),
                'date' => $min->format('d.m.Y')
            ];
            if ($date == Carbon::now()->isoFormat($format)){
                break;
            }
            if ($type == 'months'){
                $min = $min->addMonth();
            }else{
                $min = $min->addDay();
            }

            $i++;
        }
        return $results;
    }

}
