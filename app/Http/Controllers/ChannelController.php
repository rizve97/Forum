<?php

namespace App\Http\Controllers;

use Session;
use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChannelController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin',['except' => 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('channel.index')->withChannels(Channel::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('channel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $validate  = Validator::make($r->toArray(), [
            'name' => ['required', 'string', 'max:255'],
        ]);
        if($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }
        $channel = new Channel;
        $channel->name = $r->name;
        $channel->slug = str_slug($r->name,'-');
        if($channel->save())
        {
            Session::flash('success','Created');
        } else{
            Session::flash('error','Something went wrong');
        }

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        return view('channel.show',compact('channel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function edit(Channel $channel)
    {
        return view('channel.edit',compact('channel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Channel $channel)
    {
        $validate  = Validator::make($r->toArray(), [
            'name' => ['required', 'string', 'max:255'],
        ]);
        if($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }
        $channel->name = $r->name;
        $channel->slug = str_slug($r->name,'-');
        if($channel->save())
        {
            Session::flash('success','Updated');
        } else{
            Session::flash('error','Something went wrong');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel)
    {
        //
    }
}
