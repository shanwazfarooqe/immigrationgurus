@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    
    <div class="content-heading">
       <span><em class="fa fa-group"></em> Add team</span> 
    </div>

    <div class="panel panel-default">
       <div class="panel-body">

      <form class="form-horizontal" action="{{ route('register') }}" method="post" id="form-register">
      @csrf
             <div class="form-group">
                <div class="col-sm-6">
                   <label class="control-label">
                      First name
                   </label>
                   <input type="text" name="first_name" class="form-control" placeholder="First name" value="{{ old('first_name') }}">
                </div>
                 <div class="col-sm-6">
                   <label class="control-label">
                      Last name
                   </label>
                   <input type="text" name="last_name" class="form-control" placeholder="Last name" value="{{ old('last_name') }}">
                </div>
             </div>
              <div class="form-group">
               
                 <div class="col-sm-6">
                   <label class="control-label">
                      Phone No
                   </label>
                   <input type="text" name="phone" class="form-control" placeholder="Phone No" value="{{ old('phone') }}">
                </div>
                 <div class="col-sm-6">
                   <label class="control-label">
                      Email ID
                   </label>
                   <input type="text" name="email" class="form-control" placeholder="Email ID" value="{{ old('email') }}">
                </div>
             </div>
             <div class="form-group">
              <div class="col-sm-6">
               <label class="control-label">
                  Level of access
                </label>
                <select name="level" id="input" class="form-control">
                  <option value="">Select level</option>
                  <option value="3" @if(old('level')==3) {{ 'selected' }} @endif>Level 1</option>
                  <option value="4" @if(old('level')==4) {{ 'selected' }} @endif>Level 2</option>
                  <option value="5" @if(old('level')==5) {{ 'selected' }} @endif>Level 3</option>
                </select>
              </div>
               <div class="col-sm-6">
                 <label class="control-label">
                    Address
                 </label>
                 <input type="text" name="address" class="form-control" placeholder="Address" value="{{ old('address') }}">
              </div>
             </div>
              <div class="form-group">
               
                 <div class="col-sm-12">
                  <div class="pull-right">
                   <button class="btn btn-lg btn-info" type="submit">Submit</button>
                  </div>  
                </div>
             </div>
             
        </form>

       </div>
    </div>
</div>
@endsection

@section('custom_js')

@endsection