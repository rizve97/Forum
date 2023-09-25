<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ProblemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['show','index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('check');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $rules = [
            'channel_id' => 'required',
            'title' => ['required','max:255'],
            'body' => ['required','min:10']
        ];
        $validate = Validator::make($r->toArray(),$rules);
        if($validate->fails())
        {
            return response()->json(array('status' => 'error','errors' => $validate->messages()),200);
        } else if($validate->passes())
        {
            $problem = new Problem;
            $problem->channel_id = $r->channel_id;
            $problem->user_id = Auth::user()->id;
            $problem->title = $r->title;
            $problem->body = $r->body;
            if($problem->save())
            {
                return response()->json(array('status' => 'success','code' => 201, 'data' => $problem , 'username' => $problem->user->name),200);
            } else {
                return response()->json(array('message' => 'Something Went Wrong'),500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function show(Problem $problem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function edit(Problem $problem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Problem $problem)
    {
        $validate  = Validator::make($r->toArray(), [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required','min:10'],
        ]);
        if($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }
        $problem->title = $r->title;
        $problem->body = $r->body;
        if($problem->save())
        {
            Session::flash('success','Created');
        } else{
            Session::flash('error','Something went wrong');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Problem $problem)
    {
        //
    }
}
