<?php

namespace App\Http\Controllers;

use App\Models\DateReport;
use App\Models\Report;
use App\Models\ReportImage;
use App\Models\Salon;
use App\Models\SalonSourceValue;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
        if (Auth::user()->hasRole('salon_admin')) {
            $reports = QueryBuilder::for(DateReport::class)
                ->orderByDesc('date')
                ->with('salon')
                ->with('reports')
                ->whereHas('salon', function (Builder $builder) {
                    $builder->where('user_id', Auth::id());
                })
                ->get();
        } else {
            $reports = DateReport::with('salon')
                ->orderByDesc('date')
                ->with('reports')
                ->get();
        }

        foreach ($reports as $report){
            $report->number_calls = $report->reports->sum('number_calls');
            $report->sum = $report->reports->sum('sum');
            $report->stayed = $report->reports->sum('stayed');
            $report->came = $report->reports->sum('came');
        }

        return Inertia::render('Reports/Index', compact('reports'))
            ->table(function (InertiaTable $table) {
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
        if (Auth::user()->hasRole('salon_admin')) {
//            if (Auth::user()->date_index != date('Y-m-d')) {
//                abort(403);
//            }
            $salons = Salon::where('user_id', Auth::id())->get();
        } else {
            $salons = Salon::all();
        }

        return Inertia::render('Reports/Create', compact('salons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

//        if (Auth::user()->hasRole('salon_admin')) {
//            if (Auth::user()->date_index != date('Y-m-d')) {
//                abort(403);
//            }
//        }

        $this->validate($request, [
            'number_calls' => 'required|array',
            'number_calls.*' => 'required|numeric',
            'came' => 'required|array',
            'came.*' => 'required|numeric',
            'stayed' => 'required|array',
            'stayed.*' => 'required|numeric',
            'sum' => 'required|array',
            'sum.*' => 'required|numeric',
            'cause' => 'nullable|array',
            'cause.*' => 'nullable|string',
            'salon_id' => 'required|exists:salons,id',
            'date' => 'required|date',
            'images' => 'nullable|array',
            'fixed' => 'required|boolean'
        ]);

        $count = DateReport::whereDate('date', $request->date)
            ->where('salon_id', $request->salon_id)
            ->count();

        if ($count > 0) {
            return back()->withErrors(['date' => ['Такое значение поля Дата уже существует.']]);
        }

        $dateReport = DateReport::create([
            'date' => $request->date,
            'salon_id' => $request->salon_id,
            'fixed' => $request->fixed
        ]);

        foreach ($request->number_calls as $index => $value) {

            Report::create([
                'number_calls' => $request->number_calls[$index],
                'came' => $request->came[$index],
                'stayed' => $request->stayed[$index],
                'salon_id' => $request->salon_id,
                'date' => $request->date,
                'date_report_id' => $dateReport->id,
                'cause' => isset($request->cause[$index]) ? $request->cause[$index] : null,
                'source_id' => $request->sources_id[$index],
                'source_value' => isset($request->sources[$index]) ? $request->sources[$index] : null,
                'sum' => $request->sum[$index]
            ]);

            SalonSourceValue::create([
                'salon_id' => $request->salon_id,
                'source_id' => $request->sources_id[$index],
                'value' => isset($request->sources[$index]) ? $request->sources[$index] : null
            ]);

        }

        foreach ($request->images as $image){
            if ($path = $this->Upload(is_array($image)?$image[0]:false)){
                ReportImage::create([
                    'date_report_id' => $dateReport->id,
                    'image' => $path
                ]);
            }
        }


        if (Auth::user()->hasRole('salon_admin')) {
            $user = User::find(Auth::id());
            $user->date_index = Carbon::parse(Auth::user()->date_index)->addDay();
            $user->save();
        }

        return Redirect::route('reports.index')->with('success', 'Отчет успешно создан');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
        if (Auth::user()->hasRole('salon_admin')) {
           $salons = Salon::where('user_id', Auth::id())->get();
        }else{
            $salons = Salon::all();
        }
        $dateReport = DateReport::where('id', $id)->with(['reports', 'images'])->first();

        return Inertia::render('Reports/Edit', compact('salons', 'dateReport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
        $exists = DateReport::where('id', $id)
            ->where('fixed', 1)->count();

        if ($exists > 0){
            if (!Auth::user()->can('can.update.fix')){
                return back()->withErrors(['fixed' => ['Отчет фиксирован']]);
            }
        }

        $this->validate($request, [
            'number_calls' => 'required|array',
            'number_calls.*' => 'required|numeric',
            'came' => 'required|array',
            'came.*' => 'required|numeric',
            'stayed' => 'required|array',
            'stayed.*' => 'required|numeric',
            'sum' => 'required|array',
            'sum.*' => 'required|numeric',
            'cause' => 'nullable|array',
            'cause.*' => 'nullable|string',
            'salon_id' => 'required|exists:salons,id',
            'date' => 'required|date',
            'images' => 'nullable|array',
            'fixed' => 'required|boolean'
        ]);

        $count = DateReport::whereDate('date', $request->date)
            ->where('salon_id', $request->salon_id)
            ->where('id', '<>', $id)
            ->count();

        if ($count > 0) {
            return back()->withErrors(['date' => ['Такое значение поля Дата уже существует.']]);
        }

        $dateReport = DateReport::where('id', $id)->update([
            'date' => $request->date,
            'salon_id' => $request->salon_id,
            'fixed' => $request->fixed
        ]);


        Report::where('date_report_id',$id)->delete();

        SalonSourceValue::where('salon_id', $request->salon_id)->delete();

        ReportImage::where('date_report_id', $id)->delete();

        foreach ($request->number_calls as $index => $value) {

            Report::create([
                'number_calls' => $request->number_calls[$index],
                'came' => $request->came[$index],
                'stayed' => $request->stayed[$index],
                'salon_id' => $request->salon_id,
                'date' => $request->date,
                'date_report_id' =>$id,
                'cause' => isset($request->cause[$index]) ? $request->cause[$index] : null,
                'source_id' => $request->sources_id[$index],
                'source_value' => isset($request->sources[$index]) ? $request->sources[$index] : null,
                'sum' => $request->sum[$index]
            ]);

            SalonSourceValue::create([
                'salon_id' => $request->salon_id,
                'source_id' => $request->sources_id[$index],
                'value' => isset($request->sources[$index]) ? $request->sources[$index] : null
            ]);

        }

        foreach ($request->images as $image){
            if (isset($image['image'])){
                ReportImage::create([
                    'date_report_id' => $id,
                    'image' => $image['image']
                ]);
            }else{
                if ($path = $this->Upload(is_array($image)?$image[0]:false)){
                    ReportImage::create([
                        'date_report_id' => $id,
                        'image' => $path
                    ]);
                }
            }

        }


        return Redirect::route('reports.index')->with('success', 'Отчет успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
        $report->delete();
        return Redirect::route('reports.index')->with('success', 'Отчет успешно удален');
    }

    private function Upload ($req)
    {
        if ($req) {
            try {
                $fileName = time() . '_' . $req->getClientOriginalName();
                $filePath = $req->storeAs('uploads', $fileName, 'public');

                return '/storage/' . $filePath;
            }catch (\Exception $exception){
                dd($req);
            }

        }
        return  false;
    }
}
