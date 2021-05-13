<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class SalonController extends Controller
{
    //
    public function index()
    {
        $salons = QueryBuilder::for(Salon::class)
            ->paginate()
            ->withQueryString();

        return Inertia::render('Salons/Index', [
            'salons' => $salons
        ])->table(function (InertiaTable $table){
            $table->addColumn('name', 'Name');
            $table->addColumn('id', 'ID');
        });
    }

    public function show(Salon $salon)
    {
        $reports = $salon->reports;
        $minData = $reports->sortBy('created_at')->first()->created_at;
        $date = $this->generateDate($minData);
        $count = $reports->count();

        foreach ($date as $key => $value){
            $tempCount = $reports->filter(function ($report)use ($value) {
                return $report->created_at->year == $value['year'] && $report->created_at->month == $value['month'];
            });
            $percents = ['percent' => $tempCount->count() * 100 / $count ];
            $date[$key] =  array_merge($date[$key], $percents);
        }

        return Inertia::render('Salons/Show',
            compact('date', 'salon'));
    }

    private function generateDate(Carbon $min)
    {
        $results = [];
        while (true){
            $date = $min->isoFormat('MMMM YYYY');

            $results[] = [
                'label' => $date,
                'month' => $min->format('m'),
                'year' => $min->format('Y')
            ];
            if ($date == Carbon::now()->isoFormat('MMMM YYYY')){
                break;
            }
            $min = $min->addMonth();
        }
        return $results;
    }
}
