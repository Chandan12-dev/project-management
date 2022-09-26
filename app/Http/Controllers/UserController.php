<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::Where('role','user')->orderBy('id','desc')->paginate(25);
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request->validate([
            'resume' => 'mimes:pdf,xlx,csv|max:2048',
        ]);
        $fileName = time().'.'.$request->resume->extension();  
        $request->resume->move(public_path('resume'), $fileName);
        $request->validated();

        if($request->active == 1){
            $verified_at = date('Y-m-d H:i:s');
        }else{
            $verified_at = NULL;
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'cv' => $fileName,
            'total_experience' => $request->total_experience,
            'current_salary' => $request->current_salary,
            'job_profile' => $request->job_profile,
            'fathername' => $request->fathername,
            'address' => $request->address,
            'whatsapp' => $request->whatsapp,
            'adhar_number' => $request->adhar_number,
            'pan_number' => $request->pan_number,
            'phone' => $request->phone,
            'active' => $request->active,
            // 'email_verified_at' => $verified_at,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        return redirect('users')->with('message','User Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.update',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.update',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($request->resume){
            $request->validate([
                'resume' => 'mimes:pdf,xlx,csv|max:2048',
            ]);
            $fileName = time().'.'.$request->resume->extension();  
            $request->resume->move(public_path('resume'), $fileName);
            $user->cv = $fileName;
        }
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
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->whatsapp = $request->whatsapp;
        $user->adhar_number = $request->adhar_number;
        $user->pan_number = $request->pan_number;
        $user->total_experience = $request->total_experience;
        $user->job_profile = $request->job_profile;
        $user->fathername = $request->fathername;
        $user->current_salary = $request->current_salary;
        $user->active = $request->active;
        // $user->email_verified_at = $verified_at;
        $user->save();
        return redirect('users')->with('message','User Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('users')->with('success', 'User is successfully deleted');
    }

    public function checkusername(Request $request){
        $username = $request->username;
        $user = User::select('username')->where('username', $username)->get();
        if ($user->isNotEmpty()) { 
            $response = [
                'code' => 1,
                'message' => 'This Username is not available'
            ];
         }else{
            $response = [
                'code' => 0,
                'message' => 'Username Available.'
            ];
         }
        return response()->json($response);
    }
}
