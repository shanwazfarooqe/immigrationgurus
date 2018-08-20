<?php

namespace App\Http\Controllers;

use App\MailTemplate;
use App\Module;
use App\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['modules'] = Module::where('company',$this->getCompany())->latest()->get();

        $data['module'] = Module::where('company',$this->getCompany())->latest()->first();

        // $data['templates'] = Template::whereHas('module', function($query) {
        //         $query->where('company', $this->getCompany());
        //     })->get();
        if($data['module'])
        {
            $data['templates'] = Template::where('module_id', $data['module']->id)->where('status',1)->latest('id')->get();
        }

        return view('email-template',$data);
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
        $rules = [
            'module_id' => 'required|string|max:191',
            'name' => 'required|string|max:191|unique:templates,name,NULL,id,module_id,'.$request->module_id,
            'subject' => 'required|string|max:191'
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
            $data= new Template;
            $data->user_id = auth()->id();
            $data->module_id = $request->module_id;
            $data->name = $request->name;
            $data->subject = $request->subject;
            $data->save();

            $ajax['id'] = $data->id;
            $ajax['redirect'] = route('templates.show',['id'=>base64_encode($data->id)]);
            $ajax['status'] = "success";
            $ajax['msg'] = "Module has been created";
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
        $template = Template::find(base64_decode($id));
        return view('show-email-template',compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = Template::find(base64_decode($id));
        return view('edit-email-template',compact('template'));
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
        $rules = [
            'module_id' => 'required|string|max:191',
            'name' => 'required|string|max:191|unique:templates,name,'.$id.',id,module_id,'.$request->module_id,
            'subject' => 'required|string|max:191'
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
            $data= Template::find($id);
            $data->user_id = auth()->id();
            $data->module_id = $request->module_id;
            $data->name = $request->name;
            $data->subject = $request->subject;
            $data->save();

            $ajax['id'] = $id;
            $ajax['redirect'] = route('templates.edit',['id'=>base64_encode($id)]);
            $ajax['status'] = "success";
            $ajax['msg'] = "Module has been updated";
        }

        echo json_encode($ajax);
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

    public function module(Request $request)
    {
        $rules = [
            'module' => 'required|string|max:191|unique:modules,name,NULL,id,company,'.$this->getCompany()
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
            $data= new Module;
            $data->name = $request->module;
            $data->company = $this->getCompany();
            $data->save();

            $ajax['id'] = $data->id;
            $ajax['status'] = "success";
            $ajax['msg'] = "Module has been created";
        }

        echo json_encode($ajax);
    }

    public function files(Request $request)
    {
        $ajax['files'] = array();
        if($request->hasFile('file'))
        {
            foreach ($request->file as $key => $file) {
                $filename = $file->getClientOriginalName();
                $ajax['files'][] = $filename;
                $file->storeAs('public/attachements/'.$request->template_id,$filename);
            }
        }
        $ajax['status'] = "success";
        echo json_encode($ajax);
    }

    public function deleteFile(Request $request)
    {
        Storage::delete('public/attachements/'.$request->template_id.'/'.$request->filename);
        $ajax['status'] = "success";
        echo json_encode($ajax);
    }

    public function mail(Request $request)
    {
        $rules = [
            'content' => 'required',
            'to' => 'nullable|string|max:191',
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
            $data= new MailTemplate;
            $data->template_id = $request->template_id;
            $data->files = $request->attachments;
            $data->content = $request->content;
            $data->to = $request->to;
            $data->cc = $request->cc;
            $data->bcc = $request->bcc;
            $data->save();

            $ajax['id'] = $data->id;
            $ajax['status'] = "success";
            $ajax['msg'] = "Email template has been created";
        }

        echo json_encode($ajax);
    }

    public function mailupdate(Request $request)
    {

        $rules = [
            'content' => 'required',
            'to' => 'nullable|string|max:191',
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
            $data = MailTemplate::where('template_id',$request->template_id)->first();
            $data->template_id = $request->template_id;
            $data->files = $request->attachments;
            $data->content = $request->content;
            $data->to = $request->to;
            $data->cc = $request->cc;
            $data->bcc = $request->bcc;
            $data->save();

            $ajax['id'] = $data->id;
            $ajax['status'] = "success";
            $ajax['msg'] = "Email template has been updated";
        }

        echo json_encode($ajax);
    }

    public function detail($id)
    {
        $data['modules'] = Module::where('company',$this->getCompany())->latest()->get();

        $data['module'] = Module::where('id',base64_decode($id))->first();

        $data['templates'] = Template::where('module_id', base64_decode($id))->where('status',1)->latest('id')->get();
        $data['id'] = base64_decode($id);
        
        return view('email-template',$data);
    }

    public function status(Request $request, $id)
    {
        if($request->status==1)
        {
            $st =  0;
        }
        else
        {
            $st =  1;
        }

        $data = Template::find($id);
        $data->status = $st;
        $data->save();

        return redirect()->back()->with('status', 'Template has been deleted');
    }

    public function favorite(Request $request, $id)
    {
        if($request->favorite==1)
        {
            $st =  0;
        }
        else
        {
            $st =  1;
        }

        $data = Template::find($id);
        $data->favorite = $st;
        $data->save();

        return redirect()->back()->with('status', 'Favorite has been updated');
    }
}
