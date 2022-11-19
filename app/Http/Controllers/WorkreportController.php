<?php

namespace App\Http\Controllers;

use App\Models\workreport;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class WorkreportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workreports = workreport::with('project','user')->orderBy('id','desc')->paginate(50);
        return view('admin.workreport.index', compact('workreports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Auth::user()->projects;
        return view('user.workreport.create',compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'project_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'comment' => 'required',
        ]);
        $reportDate = date('Y-m-d');
        $start_time = date('H:i:s',strtotime($request->start_time));
        $end_time = date('H:i:s',strtotime($request->end_time));
        $duration = strtotime($request->end_time) - strtotime($request->start_time);
        $user_id = Auth::user()->id;
        $workreport = workreport::create([
            'project_id' => $request->project_id,
            'user_id' => $user_id,
            'duration' => $duration,
            'report_date' => $reportDate,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'comment' => $request->comment,
        ]);
        
        return redirect('workreport')->with('message','WorkPreport Submitted Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\workreport  $workreport
     * @return \Illuminate\Http\Response
     */
    public function show(workreport $workreport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\workreport  $workreport
     * @return \Illuminate\Http\Response
     */
    public function edit(workreport $workreport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\workreport  $workreport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, workreport $workreport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\workreport  $workreport
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workreport = workreport::findOrFail($id);
        $workreport->delete();
        return redirect('workreport')->with('success', 'WorkReport deleted successfully.');
    }

    public function UserWorkReport()
    {
        // $user_id = Auth::user()->user_id;
        // $workreports = workreport::with('project')->where('user_id',$user_id)->orderBy('id','desc')->paginate(50);
        $workreports = Auth::user()->workreports;
        return view('user.workreport.index', compact('workreports'));
    }
}
