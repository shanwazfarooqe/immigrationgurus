<?php

namespace App\Http\Controllers;

use App\Category;
use App\Form;
use App\FormData;
use App\FormFile;
use App\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
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
        $categories = Category::where('company',$this->getCompany())->latest('id')->get();
        return view('form',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('company',$this->getCompany())->latest('id')->get();
        return view('create-form',compact('categories'));
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
            'category_id' => 'required',
            'title' => 'required|string|unique:forms,title,NULL,id,category_id,'.$request->category_id,
            'content' => 'required',
            'org_content' => 'required'
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
            $data= new Form;
            $data->user_id = Auth::id();
            $data->category_id = $request->category_id;
            $data->title = $request->title;
            $data->content = $request->content;
            $data->org_content = $request->org_content;
            $data->save();

            $ajax['status'] = "success";
            $ajax['msg'] = "Form has been created";
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
        $category = Category::find(base64_decode($id));
        $leads = Lead::where('company',$this->getCompany())->latest()->get();
        return view('category-form',compact('category','leads'));
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
        //
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

    public function category(Request $request)
    {
        $rules = [
            'category' => 'required|string|max:191|unique:categories,name,NULL,id,company,'.$this->getCompany()
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
            $data= new Category;
            $data->name = $request->category;
            $data->company = $this->getCompany();
            $data->save();

            $ajax['id'] = $data->id;
            $ajax['status'] = "success";
            $ajax['msg'] = "Category has been created";
        }

        echo json_encode($ajax);
    }

    public function customer(Request $request)
    {
        $data = Category::find($request->category_id);
        $data->lead_id = json_encode($request->customer_id);
        $data->save();

        return redirect()->route('forms.index')->with('status','Customer has been assigned');
    }

    public function view($id)
    {
        $category = Category::find(base64_decode($id));
        return view('form-view',compact('category'));
    }

    public function data($id)
    {
        $formdata = FormData::find(base64_decode($id));
        $category = $formdata->form->category;
        $formdatas = FormData::where('unique_id',$formdata->unique_id)->get();
        $formfiles = FormFile::where('unique_id',$formdata->unique_id)->get();

        return view('data-form',compact('category','formdatas','formfiles'));
    }
}
