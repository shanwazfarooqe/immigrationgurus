@extends('layouts.master')

@section('content')
@if(LaravelGmail::check())
<div class="content-wrapper">
  
  <h3>MailBox</h3>
  <div class="pull-right">{{ LaravelGmail::user() }}</div>
  <a href="{{ url('oauth/gmail/logout') }}">logout</a>
  <div class="table-grid table-grid-desktop">
     <div class="col col-md">
        <div class="pr">
           <div class="clearfix mb">
              <button type="button" data-toggle="collapse" data-target=".mb-boxes" class="btn btn-sm btn-default mb-toggle-button pull-right dropdown-toggle">
                 <em class="fa fa-bars fa-fw fa-lg"></em>
              </button>
              <a href="#" class="btn btn-purple btn-sm mb-compose-button">
                 <em class="fa fa-pencil"></em>
                 <span>Compose</span>
              </a>
           </div>
           <!-- START mailbox list-->
           <div class="mb-boxes collapse">
              <div class="panel panel-default">
                 <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                       <li class="p">
                          <small class="text-muted">MAILBOXES</small>
                       </li>
                       <li class="active">
                          <a href="#">
                             <span class="label label-green pull-right">42</span>
                             <em class="fa fa-fw fa-lg fa-inbox"></em>
                             <span>Inbox</span>
                          </a>
                       </li>
                       <li>
                          <a href="#">
                             <span class="label label-green pull-right">10</span>
                             <em class="fa fa-fw fa-lg fa-star"></em>
                             <span>Starred</span>
                          </a>
                       </li>
                       <li>
                          <a href="#">
                             <span class="label label-green pull-right">0</span>
                             <em class="fa fa-fw fa-lg fa-paper-plane-o"></em>
                             <span>Sent</span>
                          </a>
                       </li>
                       <li>
                          <a href="#">
                             <span class="label label-green pull-right">5</span>
                             <em class="fa fa-fw fa-lg fa-edit"></em>
                             <span>Draft</span>
                          </a>
                       </li>
                       <li>
                          <a href="#">
                             <span class="label label-green pull-right">0</span>
                             <em class="fa fa-fw fa-lg fa-trash"></em>
                             <span>Trash</span>
                          </a>
                       </li>
                      
                    </ul>
                 </div>
              </div>
           </div>
           <!-- END mailbox list-->
        </div>
     </div>
     <div class="col">
        <!-- START action buttons-->
        <div class="clearfix mb">
           <div class="btn-group pull-left">
              <button type="button" class="btn btn-default btn-sm">
                 <em class="fa fa-mail-reply text-gray-dark"></em>
              </button>
              <button type="button" class="btn btn-default btn-sm">
                 <em class="fa fa-mail-reply-all text-gray-dark"></em>
              </button>
              <button type="button" class="btn btn-default btn-sm">
                 <em class="fa fa-mail-forward text-gray-dark"></em>
              </button>
           </div>
           <div class="btn-group pull-right">
              <button type="button" class="btn btn-default btn-sm">
                 <em class="fa fa-exclamation text-gray-dark"></em>
              </button>
              <button type="button" class="btn btn-default btn-sm">
                 <em class="fa fa-times text-gray-dark"></em>
              </button>
           </div>
        </div>
        <!-- END action buttons-->
        <div class="panel panel-default">
           <div class="panel-body">
              <!-- p.lead.text-centerNo mails here-->
              <table class="table table-hover mb-mails">
                 <tbody>
                  @if(LaravelGmail::check())
                    @php
                      $messages = LaravelGmail::message()->in( $box = 'inbox' )->preload()->all($pageToken = null)->take(2);
                    @endphp
                    @foreach ( $messages as $message )
                    <tr>
                       <td>
                          <div class="checkbox c-checkbox">
                             <label>
                                <input type="checkbox">
                                <span class="fa fa-check"></span>
                             </label>
                          </div>
                       </td>
                       <td class="text-center">
                          <em class="fa fa-lg fa-star-o text-muted"></em>
                       </td>
                       <td>
                          <img alt="Mail Avatar" src="img/user/01.jpg" class="mb-mail-avatar pull-left">
                          <div class="mb-mail-date pull-right">10 minutes ago</div>
                          <div class="mb-mail-meta">
                             <div class="pull-left">
                                <div class="mb-mail-subject">Admin web application</div>
                                <div class="mb-mail-from">Evelyn Holmes</div>
                             </div>
                             <div class="mb-mail-preview">{!! $message->getHtmlBody() !!}</div>
                          </div>
                       </td>
                    </tr>
                    @endforeach
                 @endif
                 </tbody>
              </table>
           </div>
        </div>
     </div>
  </div>
  
</div>
@endif
@endsection

@section('custom_js')

@endsection