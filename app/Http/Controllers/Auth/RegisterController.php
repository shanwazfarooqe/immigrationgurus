<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Lead;
use App\Mail\WelcomeMail;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/teams';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'phone' => 'required|string',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'nullable|string|min:8',
            'level' => 'required|string',
            'address' => 'nullable|string|max:191'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $pwd = str_random(8);
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($pwd),
            'level' => $data['level'],
            'address' => $data['address'],
            'company' => $this->getCompany()
        ]);

        $user2 = array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => $pwd,
            'level' => $data['level'],
            'address' => $data['address'],
            'company' => $this->getCompany()
        );

        Mail::to($data['email'])->send(new WelcomeMail($user2));

        return $user;
    }

    public function view()
    {
        $users = User::whereNotIn('level', [1,2])
                ->where('company',$this->getCompany())
                ->latest()->get();
        return view('teams',compact('users'));
    }

    public function companies()
    {
        if (!Gate::allows('isSuperAdmin')) {
            abort(404,"Sorry you are not authorized");
        }

        $users = User::where('level',2)->latest()->get();
        return view('companies',compact('users'));
    }

    public function company_add()
    {
        if (!Gate::allows('isSuperAdmin')) {
            abort(404,"Sorry you are not authorized");
        }

        return view('create-company');
    }

    public function company_store(Request $request)
    {
        if (!Gate::allows('isSuperAdmin')) {
            abort(404,"Sorry you are not authorized");
        }

        $pwd = str_random(8);
        $path = NULL;

        $validatedData = $request->validate([
            'company_name' => 'required|string|max:191|unique:users',
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'phone' => 'required|string',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'nullable|string|min:8',
            'address' => 'nullable|string|max:191',
            'logo' => 'file|image|mimes:jpeg,bmp,png'
        ]);

        if($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $path = $request->logo->store('storage/uploads','public');
        }

        $data = new User;
        $data->company_name = $request->company_name;
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->password = Hash::make($pwd);
        $data->address = $request->address;
        $data->level = 2;
        if($request->hasFile('logo'))
        {
            $data->logo = $path;
        }
        $data->save();

        $user2 = array(
            'company_name' => $request->company_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $pwd,
            'level' => 2,
            'address' => $request->address,
            'logo' => $path,
        );

        Mail::to($data['email'])->send(new WelcomeMail($user2));

        return redirect('companies')->with('status', 'Company has been created');
    }

    public function status(Request $request)
    {
        if($request->status==1)
        {
            $st =  0;
        }
        else
        {
            $st =  1;
        }

        $data = User::find($request->id);
        $data->status = $st;
        $data->save();

        if (Gate::allows('isSuperAdmin')) {
            return redirect('companies')->with('status', 'Status has been updated');
        }
        return redirect('teams')->with('status', 'Status has been updated');
    }

    public function profile()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        if (Gate::allows('isSuperAdmin') || Gate::allows('isCompany')) {
            $company_name_required = 'required';
        }
        else
        {
            $company_name_required = 'nullable';
        }

        $rules = [
            'company_name' => $company_name_required.'|string|max:191|unique:users,company_name,'.$request->id,
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'phone' => 'required|string',
            'address' => 'nullable|string|max:191',
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

            $user= User::find($request->id);
            $user->company_name = $request->company_name;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            if($request->hasFile('logo'))
            {
                $user->logo = $path;
            }
            $user->save();

            if (Gate::allows('isCustomer'))
            {
                $lead= Lead::where('email',$request->email)->first();
                $lead->first_name = $request->first_name;
                $lead->last_name = $request->last_name;
                $lead->email = $request->email;
                $lead->phone = $request->phone;
                $lead->address = $request->address;
                $lead->save();
            }

            $ajax['status'] = "success";
            $ajax['msg'] = "Profile has been updated";
        }

        echo json_encode($ajax);
    }

    public function updatepassword(Request $request)
    {
        $rules = [
            'password' => 'bail|required|string|min:8|confirmed'
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
            $user= User::find($request->id);
            $user->password = Hash::make($request->password);
            $user->save();

            $ajax['status'] = "success";
            $ajax['msg'] = "Password has been updated";
        }

        echo json_encode($ajax);
    }

    public function updateimage(Request $request)
    {
        $rules = [
            'file' => 'file|image|mimes:jpeg,bmp,png'
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
            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                $path = $request->file->store('storage/uploads','public');

                $user= User::find($request->id);
                $user->image = $path;
                $user->save();

                if (Gate::allows('isCustomer'))
                {
                    $lead= Lead::where('email',$user->email)->first();
                    $lead->image = $path;
                    $lead->save();
                }

                $ajax['status'] = "success";
                $ajax['file'] = $path;
            }
        }

        echo json_encode($ajax);
    }
}
