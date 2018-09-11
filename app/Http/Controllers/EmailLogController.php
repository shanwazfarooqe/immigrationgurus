<?php

namespace App\Http\Controllers;

use App\EmailLog;
use App\Lead;
use Illuminate\Http\Request;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmailLogController extends Controller
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
        $rules = [
            'to' => 'required',
            'subject' => 'required|string|max:191',
            'content' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if($validation->fails())
        {
            $errors = $validation->errors();
            $ajax['status'] = "error";
            $ajax['msg'] = $errors->all()[0];
        }
        else
        {
            if ($request->has('old_files')) {
                $old_files = json_decode($request->old_files);
            }

            if($request->hasFile('file'))
            {
                foreach ($request->file as $key => $file) {
                    $filename = $file->getClientOriginalName();
                    $path = $file->storeAs('public/uploads/'.$request->template_id,$filename);
                    $files[] = str_replace('public/', 'storage/', $path);
                }
            }

            if(!empty($old_files))
            {
                foreach ($old_files as $key => $value) {
                    $files[] = 'public/attachements/'.$request->template_id.'/'.$value;
                }
            }

            $data= new EmailLog;
            $data->user_id = auth()->id();
            $data->lead_id = $request->lead_id;
            $data->subject = $request->subject;
            $data->content = $request->content;
            $data->files = json_encode($files);
            $data->to = $request->to;
            $data->cc = $request->cc;
            $data->bcc = $request->bcc;
            $data->regards = $request->regards;
            $data->save();

            $ajax['id'] = $data->id;
            $ajax['status'] = "success";
            $ajax['msg'] = "Email log has been created";

            $arr = array(
                'user' => Lead::find($request->lead_id),
                'to' => $request->to,
                'subject' => $request->subject,
                'content' => $request->content,
                'regards' => $request->regards
            );

            // config([
            //     'mail.host' => 'smtp.gmail.com',
            //     'mail.port' =>  587,
            //     'mail.username' =>  'shabana@ishdesigns.com.au',
            //     'mail.password' =>  'Azmin@g3&ish'
            // ]);

            Config::set('mail.driver', 'smtp');
            Config::set('mail.host', 'smtp.gmail.com');
            Config::set('mail.port', 587);
            Config::set('mail.username', 'shibilasherin.g3interactive@gmail.com');
            Config::set('mail.password', 'junior@g3');
            Config::set('mail.from.address', 'shibilasherin.g3interactive@gmail.com');
            Config::set('mail.from.name', 'Shabana');
            Config::set('mail.encryption', 'tls');
            (new MailServiceProvider(app()))->register();

            $array = Config::get('mail'); 
            //dd($array);

            Mail::send('emails.maillog', compact('arr'), function($message) use($arr, $files){
             $message->to($arr['to'])->subject
                ($arr['subject']);
                foreach ($files as $key => $value) {
                    $strpath = public_path().'\\'.str_replace('/', '\\', $value);
                    $message->attach(str_replace('public\public\\', 'storage\app\public\\', $strpath));
                }
            });
        }

        echo json_encode($ajax);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $emaillog = EmailLog::with(['emaillogcomments' => function ($q) {
                                $q->where('status',1);
                            }])->where('id',base64_decode($id))->first();
        return view('email-log-detail',compact('emaillog'));
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

        $data = EmailLog::find($id);
        $data->status = $st;
        $data->save();

        return redirect()->back()->with('status', 'Email log has been deleted');
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
