<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $visitors = Visitor::orderBy('created_at', 'desc')
        
        ->paginate(20);
        
        
        
        return view('visitors/index', [
        
        'visitors' => $visitors
        
        ]);
        
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        return view('visitors/create');
        
        }
        
        

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $request->validate([
        
        'name' => 'required',
        
        'comments' => 'required'
        
        ]);
        
        
        
        Visitor::create($request->all());
        
        
        
        return redirect()->route('visitors.index')
        
        ->with('success', 'Signing created successfully.');
        
        }
        
        

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show(Visitor $visitor) {

        return view('visitors.show', [
        
        'visitor' => $visitor
        
        ]);
        
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitor $visitor) {

        return view('visitors.edit', [
        
        'visitor' => $visitor
        
        ]);
        
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visitor $visitor) {

        $request->validate([
        
        'name' => 'required',
        
        'comments' => 'required'
        
        ]);
        
        
        
        $visitor->update($request->all());
        
        
        
        return redirect()->route('visitors.index')
        
        ->with('success', 'Signing updated successfully');
        
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor) {

        $visitor->delete();
        
        
        
        return redirect()->route('visitors.index')
        
        ->with('success', 'Signing deleted successfully');
        
        }
}
