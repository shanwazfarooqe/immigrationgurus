<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Category;
use App\DecEmailLog;
use App\EmailLog;
use App\FormData;
use App\FormFile;
use App\Invoice;
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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');

        if (!Gate::allows('isCustomer')) {
            redirect('login');
        }
    }

    public function index()
    {
        $user = Lead::where('email',auth()->user()->email)->first();
        $id = $user->id;
        $data['lead'] = Lead::find($id);
        $data['modules'] = Module::with(['templates' => function ($q) {
                                $q->where('status',1)->latest('id');
                            }])->where('company',$this->getCompany())->latest('id')->get();
        $data['email_logs'] = EmailLog::where('lead_id',$id)->where('status',1)->latest('id')->get();
        $data['categories'] = Category::where('company',$this->getCompany())->latest('id')->get();
        $data['invoices'] = Invoice::where('lead_id',$id)->latest('id')->get();

        return view('customer-dashboard',$data);
    }
}
