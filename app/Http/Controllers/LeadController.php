<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Category;
use App\EmailLog;
use App\FormData;
use App\FormFile;
use App\Lead;
use App\Mail\WelcomeMail;
use App\Module;
use App\Note;
use App\Organization;
use App\Social;
use App\Task;
use App\Template;
use App\User;
use App\Visa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        $data['categories'] = Category::where('company',$this->getCompany())->latest('id')->get();

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

    public function status(Request $request, $id)
    {
        $pwd = str_random(8);

        $data = Lead::find($id);
        $data->status = $request->status;
        $data->save();

        $user  = new User;
        $user->first_name = $data->first_name;
        $user->last_name = $data->last_name;
        $user->email = $data->email;
        $user->phone = $data->phone;
        $user->address = $data->address;
        $user->company = $this->getCompany();
        $user->password = Hash::make($pwd);
        $user->level = 6;
        $user->save();

        $user2 = array(
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'phone' => $data->phone,
            'email' => $data->email,
            'password' => $pwd,
            'level' => 6,
            'address' => $data->address,
            'company' => $this->getCompany()
        );

        Mail::to($data->email)->send(new WelcomeMail($user2));

        return redirect()->back()->with('status', 'Status has been updated');
    }

    public function categories(Request $request)
    {
        $data = Lead::find($request->lead_id);
        $data->category_user = $request->user_id;
        $data->category_id = json_encode($request->category_id);
        $data->save();

        return redirect()->back()->with('status', 'Form has been assigned');
    }

    public function application($id)
    {
        $id = base64_decode($id);
        $lead = Lead::find($id);
        if(!empty($lead->category_id))
        {
            $categories = Category::whereIn('id',json_decode($lead->category_id))->latest('id')->get();
        }
        else
        {
            $categories = array();
        }
        
        return view('application',compact('categories','id'));
    }

    public function detail($id,$form)
    {
        $id = base64_decode($id);
        $category = Category::find(base64_decode($form));
        return view('show-form',compact('category','id'));
    }

    public function formdata(Request $request)
    {
        $unique_id = str_random(8).uniqid();

        $form_id = $request->form_id;
        $form_data = $request->form_data;

        if(!empty($form_id))
        {
            foreach ($form_id as $key => $row) {
                $data = new FormData;
                $data->form_id = $form_id[$key];
                $data->content = $form_data[$key];
                $data->user_id = auth()->id();
                $data->unique_id = $unique_id;
                $data->save();
            }
        }

        if($request->hasFile('file'))
        {
            foreach ($request->file as $key => $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('public/uploads/files/',$filename);
                $files[] = str_replace('public/', 'storage/', $path);
            }

            $data2 = new FormFile;
            $data2->category_id = $request->category_id;
            $data2->files = json_encode($files);
            $data2->user_id = auth()->id();
            $data2->unique_id = $unique_id;
            $data2->save();
        }

        $ajax['status'] = "success";
        $ajax['msg'] = "Form data has been created";

        echo json_encode($ajax);
    }

    public function view($id,$lead)
    {
        $id = base64_decode($id);
        $category = Category::find($id);
        $formdatas = FormData::where('user_id',base64_decode($lead))->get()->unique('unique_id');
        return view('form-lead-view',compact('category','formdatas','id'));
    }

    public function data($id,$lead)
    {
        $lead = base64_decode($lead);
        $formdata = FormData::find(base64_decode($id));
        $category = $formdata->form->category;
        $formdatas = FormData::where('unique_id',$formdata->unique_id)->get();
        $formfiles = FormFile::where('unique_id',$formdata->unique_id)->get();

        return view('data-lead-form',compact('category','formdatas','formfiles','lead'));
    }
}
