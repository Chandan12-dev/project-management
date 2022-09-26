<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectCategory;
use App\Models\Attahcment;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('assignBy','category')->orderBy('id','desc')->paginate(50);
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
        return view('admin.projects.update',compact('project'));
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
            'email' => 'required|string|email|max:255',
            'phone' => 'required|digits:10',
            'whatsapp' => 'max:10',
            'adhar_number' => 'required|integer|digits:12',
            'pan_number' => 'max:10',
            'total_experience' => 'required|string',
            'job_profile' => 'required|string',
        ]);

        if($request->active == 1){
            $verified_at = date('Y-m-d H:i:s');
        }else{
            $verified_at = NULL;
        }
        
        $project->name = $request->name;
        $project->email = $request->email;
        $project->address = $request->address;
        $project->phone = $request->phone;
        $project->whatsapp = $request->whatsapp;
        $project->adhar_number = $request->adhar_number;
        $project->pan_number = $request->pan_number;
        $project->total_experience = $request->total_experience;
        $project->job_profile = $request->job_profile;
        $project->fathername = $request->fathername;
        $project->current_salary = $request->current_salary;
        $project->active = $request->active;
        // $project->email_verified_at = $verified_at;
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

    public function project_filter(){
        
    }
}
