<?php

namespace App\Http\Controllers;

use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class GmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $access_token;
    protected $url;

    public function __construct()
    {
        $this->middleware('auth');
        if(!LaravelGmail::check())
        {
            redirect('/oauth/gmail');
        }
        $this->access_token = LaravelGmail::getToken()['access_token'];
        $this->url = "https://www.googleapis.com/gmail/v1/users/me/";
    }

    public function index($pageToken=null)
    {
        $gmailall = LaravelGmail::message()->in( $box = 'inbox' )->all();
        $inbox = count($gmailall);

        $message_url = $this->url."messages?maxResults=10&q=in:inbox&access_token=".$this->access_token."&pageToken=".$pageToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $message_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $gmails = json_decode(curl_exec($ch), true);
        $token = $this->access_token;

        return view('email-api',compact('gmails','token','pageToken','inbox'));
    }

    public function trash($id=null)
    {
        $posts =array('id'=>$id);

        $message_url = $this->url."messages/".$id."/trash?access_token=".$this->access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $message_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, $posts ? 0 :1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($posts));
        $response = json_decode(curl_exec($ch), true);
        if($response){
            return redirect()->route('gmail')->with('status','Email has been deleted');
        } else {
            return redirect()->route('gmail')->with('status','Email could not deleted');
        }
    }

    public function delete($id=null)
    {
        $posts =array('id'=>$id);

        $message_url = $this->url."messages/".$id."?access_token=".$this->access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $message_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $response = json_decode(curl_exec($ch), true);
        //dd($response);
        if($response){
            return redirect()->route('gmail')->with('status','Email has been deleted');
        } else {
            return redirect()->route('gmail')->with('status','Email could not deleted');
        }
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;

        $queryParams = array(
          'ids' => json_decode($ids)
        );

        $posts = json_encode($queryParams);

        //dd($posts);

        $message_url = $this->url."messages/batchDelete?access_token=".$this->access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $message_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, $posts ? 0 :1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$posts);
        $response = json_decode(curl_exec($ch), true);
        //dd($response);
        if($response){
            return redirect()->route('gmail')->with('status','Email has been deleted');
        } else {
            return redirect()->route('gmail')->with('status','Email could not deleted');
        }
    }

    public function trashAll(Request $request)
    {
        $ids = json_decode($request->ids);
        $response = array();

        foreach($ids as $id):
        $posts =array('id'=>$id);
        $message_url = $this->url."messages/".$id."/trash?access_token=".$this->access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $message_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, $posts ? 0 :1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($posts));
        $response[] = json_decode(curl_exec($ch), true);
        endforeach;

        if($response){
            return redirect()->route('gmail')->with('status','Email has been deleted');
        } else {
            return redirect()->route('gmail')->with('status','Email could not deleted');
        }
    }
}
