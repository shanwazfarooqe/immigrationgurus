<?php

namespace App\Http\Controllers;

use App\DecEmailLogComment;
use App\Lead;
use Illuminate\Http\Request;

class DecEmailLogCommentController extends Controller
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
        $files = array();
        $request->validate([
            'content' => 'required',
            'file.*' => 'required'
        ]);

        $data = new DecEmailLogComment;
        $data->content = $request->content;
        $data->dec_email_log_id = $request->dec_email_log_id;
        $data->user_id = auth()->id();
        if($request->hasFile('file'))
        {
            foreach ($request->file as $key => $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/uploads',$filename);
                $files[] = str_replace('public/', 'storage/', $path);
            }
            $data->files = json_encode($files);
        }
        $data->save();

        $arr = array(
            'user' => Lead::find($request->lead_id),
            'to' => $request->to,
            'subject' => $request->subject,
            'content' => $request->content,
            'regards' => $request->regards
        );

        return redirect()->back()->with('status', 'Comment has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->status==1)
        {
            $st =  0;
        }
        else
        {
            $st =  1;
        }

        $data = DecEmailLogComment::find($id);
        $data->status = $st;
        $data->save();

        return redirect()->back()->with('status', 'Comment has been deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
