<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
//use Webklex\IMAP\Client;
use Webklex\IMAP\Facades\Client;

class ImapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        //
    }

    public function index()
    {
        $oClient = Client::account('default');
        if($oClient->connect())
        {
            echo "success";
        }
        else
        {
            echo "Failure";
        }
    }

}
