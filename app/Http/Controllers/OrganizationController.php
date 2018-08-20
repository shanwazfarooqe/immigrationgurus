<?php

namespace App\Http\Controllers;

use App\Lead;
use App\Module;
use App\OrgActivity;
use App\OrgEmailLog;
use App\OrgNote;
use App\OrgTask;
use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
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
        $organizations = Organization::where('company',$this->getCompany())->latest()->get();
        return view('organizations',compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create-organization');
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
            'name' => 'required|string|max:191',
            'phone' => 'nullable|string|max:191',
            'email' => 'required|email|unique:organizations',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
            'logo' => 'file|image|mimes:jpeg,bmp,png'
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
            if($request->hasFile('logo'))
            {
                $file = $request->file('logo');
                $path = $request->logo->store('storage/uploads','public');
            }

            $data= new Organization;
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->website = $request->website;
            $data->address = $request->address;
            $data->logo = $path;
            $data->company = $this->getCompany();
            $data->save();

            $ajax['id'] = $data->id;
            $ajax['status'] = "success";
            $ajax['msg'] = "Organisation has been created";
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
        $data['organization'] = Organization::find(base64_decode($id));
        $data['leads'] = Lead::where('organization_id',base64_decode($id))->latest('id')->get();

        $data['notes'] = OrgNote::where('organization_id',base64_decode($id))->latest()->get();
        $data['activities'] = OrgActivity::where('organization_id',base64_decode($id))->latest()->get();
        $data['tasks'] = OrgTask::where('organization_id',base64_decode($id))->latest()->get();
        $data['modules'] = Module::with(['templates' => function ($q) {
                                $q->where('status',1)->latest('id');
                            }])->where('company',$this->getCompany())->latest('id')->get();
        $data['email_logs'] = OrgEmailLog::where('organization_id',base64_decode($id))->where('status',1)->latest('id')->get();

        return view('show-organization',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organization = Organization::find(base64_decode($id));
        return view('edit-organization',compact('organization'));
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
            'name' => 'required|string|max:191',
            'phone' => 'nullable|string|max:191',
            'email' => 'required|email|unique:organizations,email,'.$id,
            'website' => 'nullable|url',
            'address' => 'nullable|string',
            'logo' => 'file|image|mimes:jpeg,bmp,png'
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

            $data= Organization::find($id);
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->website = $request->website;
            $data->address = $request->address;
            if($request->hasFile('logo'))
            {
                $file = $request->file('logo');
                $path = $request->logo->store('storage/uploads','public');
                $data->logo = $path;
            }
            $data->company = $this->getCompany();
            $data->save();

            $ajax['status'] = "success";
            $ajax['msg'] = "Organisation has been updated";
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
        $data = Organization::find($id);
        $data->delete();
        return redirect('organizations')->with('status', 'Data has been deleted');
    }
}
