<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlternativeRequest;
use App\Models\Alternative;
use Illuminate\Http\Request;
use App\Models\Criteria;

class AlternativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $criterias = Criteria::select('id', 'name', 'type', 'weight')->get();
        return view('alternatives.create', compact('criterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlternativeRequest $request)
    {
        Alternative::create($request->validated());

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alternative $alternative)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alternative $alternative)
    {
        $criterias = Criteria::select('id', 'name', 'type', 'weight')->get();
        return view('alternatives.edit', compact('criterias', 'alternative'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alternative $alternative)
    {
        $alternative->update([
            'name' => $request->input('name'),
            'c1' => $request->input('c1'),
            'c2' => $request->input('c2'),
            'c3' => $request->input('c3'),
            'c4' => $request->input('c4'),
            'c5' => $request->input('c5'),
            'c6' => $request->input('c6'),
            'c7' => $request->input('c7'),
            'c8' => $request->input('c8'),
            'c9' => $request->input('c9'),
            'c10' => $request->input('c10'),
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alternative $alternative)
    {
        $alternative->delete();

        return redirect()->route('dashboard');
    }
}
