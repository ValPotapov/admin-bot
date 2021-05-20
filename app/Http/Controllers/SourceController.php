<?php

namespace App\Http\Controllers;


use App\Models\Salon;
use App\Models\SalonSource;
use App\Models\Source;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sources = QueryBuilder::for(Source::class)
            ->paginate()
            ->withQueryString();

        return Inertia::render('Sources/Index', [
            'sources' => $sources
        ])->table(function (InertiaTable $table) {
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
        $salons = Salon::all();

        return Inertia::render('Sources/Create', compact('salons'));
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'salons' => 'nullable|array',
            'salons.*' => 'nullable|exists:salons,id'
        ]);

        $source = Source::create($request->only('name'));
        if (!empty($request->salons)) {
            $source->for_all = 0;
            $source->save();
            $salons = $request->salons;
            foreach ($salons as $salon) {
                SalonSource::create([
                    'source_id' => $source->id,
                    'salon_id' => $salon
                ]);
            }
        } else {
            $source->for_all = 1;
            $source->save();
        }

        return Redirect::route('sources.index')->with('success', 'Источник успешно добавлен');
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
    public function edit(Source $source)
    {
        //
        $source->load('salons');
        $salons = Salon::all();

        return Inertia::render('Sources/Edit', compact('source', 'salons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Source $source)
    {
        //
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'salons' => 'nullable|array',
            'salons.*' => 'nullable|exists:salons,id'
        ]);

        SalonSource::where('source_id', $source->id)
            ->delete();

        $source->update(['name' => $request->name]);
        if (!empty($request->salons)) {
            $source->for_all = 0;
            $source->save();
            $salons = $request->salons;
            foreach ($salons as $salon) {
                SalonSource::create([
                    'source_id' => $source->id,
                    'salon_id' => $salon
                ]);
            }
        } else {
            $source->for_all = 1;
            $source->save();
        }
        return Redirect::route('sources.index')->with('success', 'Источник успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source)
    {
        //
        $source->delete();
        return Redirect::route('sources.index')->with('success', 'успешно удален');
    }

    public function getSources($salon_id)
    {
        $sources = Source::whereHas('salons', function (Builder $builder) use ($salon_id) {
            $builder->where('salons.id', $salon_id);
        })->orWhere('for_all', 1)->get();

        return response()->json($sources);
    }
}
