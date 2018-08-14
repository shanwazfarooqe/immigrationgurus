<?php

namespace App\Http\Controllers;

use App\Activity;
use App\EmailLog;
use App\Lead;
use App\Module;
use App\Note;
use App\Organization;
use App\Social;
use App\Task;
use App\Template;
use App\User;
use App\Visa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['organizations'] = Organization::where('company',$this->getCompany())->latest()->get();
        $data['users'] = User::where('company',$this->getCompany())
                        ->orWhere('id',$this->getCompany())
                        ->latest()->get();
        $data['leads'] = Lead::where('company',$this->getCompany())->latest()->get();

        return view('leads',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['visas'] = Visa::where('company',$this->getCompany())->latest()->get();
        $data['socials'] = Social::where('company',$this->getCompany())->latest()->get();
        $data['organizations'] = Organization::where('company',$this->getCompany())->latest()->get();
        $data['users'] = User::where('company',$this->getCompany())
                        ->orWhere('id',$this->getCompany())
                        ->latest()->get();
        return view('create-lead',$data);
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
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'phone' => 'nullable|string|max:191',
            'email' => 'required|email|unique:leads',
            'address' => 'required|string',
            'visa_id' => 'nullable',
            'organization_id' => 'nullable',
            'social_id' => 'nullable',
            'user_id' => 'nullable',
            'notes' => 'nullable|string',
            'image' => 'file|image|mimes:jpeg,bmp,png'
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
            $path = NULL;
            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $path = $request->image->store('storage/uploads','public');
            }

            $data= new Lead;
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->address = $request->address;
            $data->visa_id = $request->visa_id;
            $data->organization_id = $request->organization_id;
            $data->social_id = $request->social_id;
            $data->user_id = $request->user_id;
            $data->notes = $request->notes;
            $data->image = $path;
            $data->company = $this->getCompany();
            $data->save();

            $ajax['id'] = $data->id;
            $ajax['status'] = "success";
            $ajax['msg'] = "Lead has been created";
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
        $id = base64_decode($id);
        $data['notes'] = Note::where('lead_id',$id)->latest()->get();
        $data['activities'] = Activity::where('lead_id',$id)->latest()->get();
        $data['tasks'] = Task::where('lead_id',$id)->latest()->get();
        $data['lead'] = Lead::find($id);
        $data['modules'] = Module::with(['templates' => function ($q) {
                                $q->where('status',1)->latest('id');
                            }])->where('company',$this->getCompany())->latest('id')->get();
        $data['email_logs'] = EmailLog::where('lead_id',$id)->where('status',1)->latest('id')->get();

        return view('show-lead',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['visas'] = Visa::where('company',$this->getCompany())->latest()->get();
        $data['socials'] = Social::where('company',$this->getCompany())->latest()->get();
        $data['organizations'] = Organization::where('company',$this->getCompany())->latest()->get();
        $data['users'] = User::where('company',$this->getCompany())
                        ->orWhere('id',$this->getCompany())
                        ->latest()->get();
        $data['lead'] = Lead::find(base64_decode($id));
        return view('edit-lead',$data);
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
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'phone' => 'nullable|string|max:191',
            'email' => 'required|email|unique:leads,email,'.$id,
            'address' => 'required|string',
            'visa_id' => 'nullable',
            'organization_id' => 'nullable',
            'social_id' => 'nullable',
            'user_id' => 'nullable',
            'notes' => 'nullable|string',
            'image' => 'file|image|mimes:jpeg,bmp,png'
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
            $path = NULL;
            $data= Lead::find($id);
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->address = $request->address;
            $data->visa_id = $request->visa_id;
            $data->organization_id = $request->organization_id;
            $data->social_id = $request->social_id;
            $data->user_id = $request->user_id;
            $data->notes = $request->notes;
            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $path = $request->image->store('storage/uploads','public');
                $data->image = $path;
            }
            $data->company = $this->getCompany();
            $data->save();

            $ajax['id'] = $data->id;
            $ajax['status'] = "success";
            $ajax['msg'] = "Lead has been updated";
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

    public function org(Request $request)
    {
        $data = Lead::find($request->id);
        $data->organization_id = $request->organization_id;
        $data->save();
        $ajax['status'] = "success";
        $ajax['msg'] = "Organization has been updated";
        echo json_encode($ajax);
    }

    public function user(Request $request)
    {
        $data = Lead::find($request->id);
        $data->user_id = $request->user_id;
        $data->save();
        $ajax['status'] = "success";
        $ajax['msg'] = "User has been assigned";
        echo json_encode($ajax);
    }

    public function customers()
    {
        $data['organizations'] = Organization::where('company',$this->getCompany())->latest()->get();
        $data['leads'] = Lead::where('company',$this->getCompany())->whereNotNull('user_id')->latest()->get();

        return view('customers',$data);
    }

    public function getmodal(Request $request)
    {
        $id = $request->id;
        $template = Template::with('mailtemplate')->find($id);
        echo json_encode($template);
    }
}
