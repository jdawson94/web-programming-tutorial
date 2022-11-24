<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (Auth::check()){

            $visitors = Visitor::orderBy('created_at', 'desc')
            ->paginate(20);
            return view('visitors/index', [
            'visitors' => $visitors
            ]);
        }

        else {
            return view('auth/login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        if (Auth::check()){
            return view('visitors/create');
        }

        else{
            return view('auth/login');
        }    
    }
        
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        if (Auth::check()){

            $request->validate([
                'comments' => 'required'
            ]);
            
            $visitor = new Visitor;
            $visitor->user()->associate(Auth::user());
            $visitor->comments = $request->comments;
            $visitor->save();        
            return redirect()->route('visitors.index')
            ->with('success','Signing created successfully.');
        }

        else{
            abort(401);
        }
    }
        
        

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show(Visitor $visitor) {

        if (Auth::check()){
            
            $user = Auth::user();

            if($user->id == $visitor->user_id){
                return view('visitors.show', [
                    'visitor' => $visitor
                ]);
            }
            
            else{
                abort(403);
            }
        }
        
        else {
            return view('auth/login');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitor $visitor) {
        if (Auth::check()){

            $user = Auth::user();

            if($user->id == $visitor->user_id){
                return view('visitors.edit', [
                    'visitor' => $visitor
                ]);
            }

            else{
                abort(403);
            }

        }
        
        else{
            return view('auth/login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visitor $visitor)
    {
        if (Auth::check()){
            
            $user = Auth::user();

            if($user->id == $visitor->user_id){

                $request->validate([
                    'comments' => 'required'
                ]);
                
                $visitor->comments = $request->comments;
                $visitor->save();
                
                return redirect()->route('visitors.index')
                ->with('success', 'Signing updated successfully');
            }
            
            else{
                abort(403);
            }
        }

        else {
            abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor) {

        if (Auth::check()){

            $user = Auth::user();

            if($user->id == $visitor->user_id){

                $visitor->delete();
                
                return redirect()->route('visitors.index')    
                ->with('success', 'Signing deleted successfully');
            }

            else{
                abort(403);
            }   

        }

        else {
            abort(401);
        }
 
    }
}
