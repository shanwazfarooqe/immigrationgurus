<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>
    @if(Auth::user()->company_name)
      {{ Auth::user()->company_name }}
    @elseif(Auth::user()->parent->company_name)
      {{ Auth::user()->parent->company_name }}
    @else
      {{ config('app.name', 'Laravel') }}
    @endif
   </title>
   <meta name="description" content="Bootstrap Admin App + jQuery">
   <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">

   <!-- =============== VENDOR STYLES ===============-->
   <link rel="shortcut icon" href="{{ asset('img/fav.png') }}">
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="{{ asset('css/fontawesome/css/font-awesome.min.css') }}">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="{{ asset('css/simple-line-icons/css/simple-line-icons.css') }}">
   
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="{{ asset('css/app.css') }}" id="maincss">
    <!-- =============== custom ===============-->
   <link rel="stylesheet" href="{{ asset('css/theme-a.css') }}" id="maincss">
   <!-- =============== sweetalert ===============-->
   <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}" id="maincss">
  @yield('custom_css')
</head>

<body>
   <div class="wrapper">
      <!-- top navbar-->
      <header class="topnavbar-wrapper">
         <!-- START Top Navbar-->
         <nav role="navigation" class="navbar topnavbar">
            <!-- START navbar header-->
            <div class="navbar-header">
               <a href="#/" class="navbar-brand">
                  <div class="brand-logo">
                     <img src="
                     @if(Auth::user()->logo || Auth::user()->parent['logo'])
                       @if(file_exists(Auth::user()->logo))
                         {{ asset(Auth::user()->logo) }}
                       @elseif(file_exists(Auth::user()->parent->logo))
                         {{ asset(Auth::user()->parent->logo) }}
                       @endif
                     @else
                       {{ asset('img/logo.png') }}
                     @endif
                     " alt="App Logo" class="img-responsive" style="height: 60px;">
                  </div>
                  <div class="brand-logo-collapsed">
                     <img src="
                       {{ asset('img/logo-single.png') }}
                     " alt="App Logo" class="img-responsive">
                  </div>
               </a>
            </div>
            <!-- END navbar header-->
            <!-- START Nav wrapper-->
            <div class="nav-wrapper">
               <!-- START Left navbar-->
               <ul class="nav navbar-nav">
                  <li>
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a href="#" data-trigger-resize="" data-toggle-state="aside-collapsed" class="hidden-xs">
                        <em class="fa fa-navicon"></em>
                     </a>
                     <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                     <a href="#" data-toggle-state="aside-toggled" data-no-persist="true" class="visible-xs sidebar-toggle">
                        <em class="fa fa-navicon"></em>
                     </a>
                  </li>
                  <!-- START User avatar toggle-->
                  <li>
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a id="user-block-toggle" href="#user-block" data-toggle="collapse">
                        <em class="icon-user"></em>
                     </a>
                  </li>
                  <!-- END User avatar toggle-->
                  <!-- START lock screen-->
                  
                  <!-- END lock screen-->
               </ul>
               <!-- END Left navbar-->
               <!-- START Right Navbar-->
              <ul class="nav navbar-nav navbar-right">
                  <li>
                     <a href="{{ route('teams.profile') }}">
                        <em class="fa fa-cog"></em>
                     </a>
                  </li>
                
                  <li>
                     <a href="{{ route('logout') }}" onclick="event.preventDefault();logOut();">
                        <em class="fa fa-sign-out"></em>
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                  </li>
                  <!-- END Offsidebar menu-->
               </ul>
               <!-- END Right Navbar-->
            </div>
          
         </nav>
         <!-- END Top Navbar-->
      </header>
     <!-- sidebar-->
      <aside class="aside">
       
         <!-- START Sidebar (left)-->
         <div class="aside-inner">
            <nav data-sidebar-anyclick-close="" class="sidebar">
               <!-- START sidebar nav-->
               <ul class="nav">
                  <!-- START user info-->
                  <li class="has-user-block">
                     <div  id="user-block" class="collapse" >
                        <div class="item user-block">
                           <!-- User picture-->
                           <div class="user-block-picture">
                              <div class="user-block-status">
                                 <img src="{{ (file_exists(Auth::user()->image)) ? asset(Auth::user()->image) : asset('img/user/8.jpg') }}" alt="Avatar" style="width:40px;height:40px;" class="img-thumbnail img-circle">
                                 <div class="circle circle-success circle-lg"></div>
                              </div>
                           </div>
                           <!-- Name and Job-->
                           <div class="user-block-info">
                              <span class="user-block-name">Hello, {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                              <span class="user-block-role">{{ Auth::user()->role->name }}</span>
                           </div>
                        </div>
                     </div>
                  </li>
              @if(Gate::check('isCompany') || Gate::check('isAdmin'))    
              <li class=" ">
                  <a href="{{ url('/') }}" title="Dashboard">
                  <em class="fa fa-dashboard"></em>
                      <span>Dashboard</span>
                  </a>
              </li>
              <li class="drop-menu">
               <a href="#Lead" title="Lead" data-toggle="collapse" class="arrow-r">
                    <em class="fa fa-sitemap"></em>
                   <span>Lead</span>
                    <i class="fa fa-angle-down rotate-icon"></i>
                </a>
                <ul id="Lead" class="nav sidebar-subnav collapse">
                   <li class=" ">
                      <a href="{{ route('leads.create') }}" title="Add lead">
                         <span>Add lead</span>
                      </a>
                   </li>
                    <li class=" ">
                      <a href="{{ route('leads.index') }}" title="View lead">
                         <span>View lead</span>
                      </a>
                   </li>
                </ul>
               </li> 

                 <li class=" ">
                   <a href="{{ route('leads.customers') }}" title="Customers">
                  <em class="fa fa-user"></em>
                      <span>Customers</span>
                   </a>
                </li>
                 <li class="drop-menu">
               <a href="#orgsd" title="Manage organisation" data-toggle="collapse" class="arrow-r">
                    <em class="fa fa-cubes"></em>
                   <span>Organisation</span>
                    <i class="fa fa-angle-down rotate-icon"></i>
                </a>
                <ul id="orgsd" class="nav sidebar-subnav collapse">
                   <li class=" ">
                      <a href="{{ route('organizations.create') }}" title="Add organisation">
                         <span>Add organisation</span>
                      </a>
                   </li>
                      <li class=" ">
                      <a href="{{ route('organizations.index') }}" title="View organisation">
                         <span>View organisation</span>
                      </a>
                   </li>
                </ul>
               </li>
               <li class="drop-menu">
               <a href="#team" title="Manage team" data-toggle="collapse" class="arrow-r">
                    <em class="fa fa-group"></em>
                   <span>Manage team</span>
                    <i class="fa fa-angle-down rotate-icon"></i>
                </a>
                <ul id="team" class="nav sidebar-subnav collapse">
                   <li class=" ">
                      <a href="{{ route('register') }}" title="Add team">
                         <span>Add team</span>
                      </a>
                   </li>
                      <li class=" ">
                      <a href="{{ route('teams') }}" title="View team">
                         <span>View team</span>
                      </a>
                   </li>
                </ul>
               </li>
               @endif

               @can('isSuperAdmin')
               <li class="drop-menu">
               <a href="#company" title="Manage company" data-toggle="collapse" class="arrow-r">
                    <em class="fa fa-group"></em>
                   <span>Manage company</span>
                    <i class="fa fa-angle-down rotate-icon"></i>
                </a>
                <ul id="company" class="nav sidebar-subnav collapse">
                   <li class=" ">
                      <a href="{{ route('companies.register') }}" title="Add company">
                         <span>Add company</span>
                      </a>
                   </li>
                      <li class=" ">
                      <a href="{{ route('companies') }}" title="View company">
                         <span>View company</span>
                      </a>
                   </li>
                </ul>
               </li>
               @endcan

              @if(Gate::check('isCompany') || Gate::check('isAdmin'))  
               <li class=" ">
                   <a href="email.html" title="Email">
                  <em class="fa fa-envelope-o"></em>
                      <span>Email</span>
                   </a>
                </li>
                
               <li class="drop-menu">
               <a href="#sett" title="Settings" data-toggle="collapse" class="arrow-r">
                    <em class="fa fa-cog"></em>
                   <span>Settings</span>
                    <i class="fa fa-angle-down rotate-icon"></i>
                </a>
                <ul id="sett" class="nav sidebar-subnav collapse">
                  <li class=" ">
                      <a href="{{ route('forms.index') }}" title="Web form">
                         <span>Web form</span>
                      </a>
                   </li>
                    <li class=" ">
                      <a href="{{ route('teams.profile') }}" title="Profile">
                         <span>Profile</span>
                      </a>
                   </li>
                   <li class=" ">
                      <a href="{{ route('visas.index') }}" title="Visa type">
                         <span>Visa type</span>
                      </a>
                   </li>
                   <li class=" ">
                      <a href="{{ route('socials.index') }}" title="How did you find us">
                         <span>How did you find us</span>
                      </a>
                   </li>
                   <li class=" ">
                      <a href="{{ route('templates.index') }}" title="Manage email template">
                         <span>Email template</span>
                      </a>
                   </li>
                     
                </ul>
               </li>
               @endif 

              
               
             </ul>
                  
            </nav>
         </div>
         <!-- END Sidebar (left)-->
      
     </aside>
    
      <section>
        <!-- Page content-->
        @yield('content')
      </section>
      <!-- Page footer-->
      <footer>
         <span>&copy; <span id="demoyear"></span> - Immigration Gurus powered by ishtechnologies</span>
      </footer>
   </div>
   <!-- =============== VENDOR SCRIPTS ===============-->
   <!-- JQUERY-->
   <script src="{{ asset('js/jquery.js') }}"></script>
   <!-- BOOTSTRAP-->
   <script src="{{ asset('js/bootstrap.js') }}"></script>
   <!-- STORAGE API-->
   <script src="{{ asset('js/jquery.storageapi.js') }}"></script>
   <!-- =============== PAGE VENDOR SCRIPTS ===============-->

   <!-- =============== APP SCRIPTS ===============-->
   <script src="{{ asset('js/app.js') }}"></script>
   <!-- =============== Sweet Alert ===============-->
   <script src="{{ asset('js/sweetalert.min.js') }}"></script>
   <!-- Notify -->
   <script src="{{ asset('js/notify.min.js') }}"></script>

  <script>
    function logOut() {
      sweetAlert({
        title: "Are you sure?",
        /*text: "You will not be able to recover this banner!",*/
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: true,
        closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm) {
          $('#logout-form').submit();
        } else {
            sweetAlert('Cancelled!', "", "success");
        }
      });
    }
  </script>

  <!-- Notify -->
  <script>
    @if(session('status'))
      $.notify("{{ session('status') }}", "success");
    @endif

    $(document).ready(function() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
    });

    @if ($errors->any())
      swal('Warning','{{ $errors->all()[0] }}','warning');
    @endif
  </script>

  @yield('custom_js')

</body>
</html>