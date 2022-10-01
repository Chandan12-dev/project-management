<?php

namespace App\Http\Controllers;

use App\Models\Attahcment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attahcment  $attahcment
     * @return \Illuminate\Http\Response
     */
    public function show(Attahcment $attahcment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attahcment  $attahcment
     * @return \Illuminate\Http\Response
     */
    public function edit(Attahcment $attahcment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attahcment  $attahcment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attahcment $attahcment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attahcment  $attahcment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attahcment $attahcment)
    {
        //
    }

    public function deleteattachement(Request $request)
    {
        if($request->id){
        $attahcment = Attahcment::findOrFail($request->id);
        if(Storage::exists($attahcment->url)){
            Storage::delete($attahcment->url);
            $data = ['success' => 'File Deleted.'];
            /*
                Delete Multiple File like this way
                Storage::delete(['upload/test.png', 'upload/test2.png']);
            */
        }else{
            $data = ['success' => 'File does not exists.'];
        }
        $attahcment->delete();
    }else{
        $data = ['error' => 'File does not exists.'];
    }
        return response()->json($data);
    }
}
