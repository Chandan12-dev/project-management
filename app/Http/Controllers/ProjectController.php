<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectCategory;
use App\Models\Attahcment;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('assignBy','category','workreports')->orderBy('id','desc')->paginate(50);
        return view('admin.projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::Where('role','=','user')->orderBy('id','desc')->get();
        $categories = ProjectCategory::orderBy('id','desc')->get();
        return view('admin.projects.create',compact('users','categories'));
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
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'assign_by' => 'required|integer',
        ]);
        $project = Project::create([
            'name' => $request->name,
            'status' => $request->status,
            'duration' => $request->duration,
            'start_date' => $request->start_date,
            'project_details' => $request->project_details,
            'cat_id' => $request->cat_id,
            'assign_by' => $request->assign_by,
        ]);
        $UserIds = $request->assign_to;
        $project->assignTo()->attach($UserIds);
        if($request->hasfile('attachment'))
         {
            $FileData = [];
            foreach($request->file('attachment') as $key => $attachment)
            {
                $fileName = time().'.'.$attachment->extension();
                // $path = $attachment->move(public_path('uploads'), $fileName);
                $path = $attachment->store('uploads');
                $name = $attachment->getClientOriginalName();
                // $size = $attachment->getSize();
                $size = Storage::size($path);
                $mime = $attachment->getClientMimeType();

                $FileData[$key]['name'] = $name;
                $FileData[$key]['url'] = $path;
                $FileData[$key]['size'] = $size;
                $FileData[$key]['mime'] = $mime;
                $FileData[$key]['attachable_id'] = $project->id;
                $FileData[$key]['attachable_type'] = 'project';

                $attachm = new Attahcment;
                $attachm->name = $name;
                $attachm->url = $path;
                $attachm->size = $size;
                $attachm->mime = $mime;
                $attachm->attachable_id = $project->id;
                $attachm->attachable_type = 'project';

                $project->attachments()->save($attachm);
            }
            if(count($FileData) > 0){
                // $project->attachments()->save($FileData);
                // Attahcment::insert($FileData);
            }
         }

        return redirect('projects')->with('message','Project Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('user.projects.view',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::with(['assignTo','attachments'])->findOrFail($id);
        $users = User::Where('role','=','user')->orderBy('id','desc')->get();
        $categories = ProjectCategory::orderBy('id','desc')->get();
        return view('admin.projects.update',compact('project','users','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'assign_by' => 'required|integer',
        ]);
        
        $UserIds = $request->assign_to;
        $project->assignTo()->sync($UserIds);
        if($request->hasfile('attachment'))
         {
            foreach($request->file('attachment') as $key => $attachment)
            {
                $fileName = time().'.'.$attachment->extension();
                $path = $attachment->store('uploads');
                $name = $attachment->getClientOriginalName();
                $size = Storage::size($path);
                $mime = $attachment->getClientMimeType();

                $attachm = new Attahcment;
                $attachm->name = $name;
                $attachm->url = $path;
                $attachm->size = $size;
                $attachm->mime = $mime;
                $attachm->attachable_id = $project->id;
                $attachm->attachable_type = 'project';

                $project->attachments()->save($attachm);
            }
        }

        $project->name = $request->name;
        $project->status = $request->status;
        $project->duration = $request->duration;
        $project->start_date = $request->start_date;
        $project->project_details = $request->project_details;
        $project->cat_id = $request->cat_id;
        $project->assign_by = $request->assign_by;
        
        $project->save();
        return redirect('projects')->with('message','Project Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        
        $project->delete();
        return redirect('projects')->with('success', 'Project is successfully deleted');
    }

    public function userprojects(){
        $projects = Auth::user()->projects;
        $users = User::Where('role','=','user')->orderBy('id','desc')->get();
        $categories = ProjectCategory::orderBy('id','desc')->get();
        return view('user.projects.index',compact('projects','users','categories'));
    }
}
