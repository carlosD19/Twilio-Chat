<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Session;

class ChatController extends Controller
{

    protected $client;
    /**
     * 
     */
    public function __construct()
    {
        $this->client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = $this->client->chat->v2->services->read();
        if ($services) {
            $channels = $this->client->chat->v2->services($services[0]->sid)->channels->read();
            if (Session::has('user')) {
                $userChannels = $this->client->chat->v2->services($services[0]->sid)->users(Session::get('user.sid'))->userChannels->read();
            }
        }
        return view('chats.index', compact('channels', 'userChannels'));
    }
    /**
     * 
     */
    public function join($sid)
    {
        if (Session::has('user')) {
            $services = $this->client->chat->v2->services->read();
            if ($services) {
                try {
                    $member = $this->client->chat->v2->services($services[0]->sid)->channels($sid)->members->create(Session::get('user.identity'));
                    return redirect()->route('chats');
                } catch (\Throwable $e) {
                    return back();
                }
            }
        } else {
            return redirect('');
        }
    }
    /**
     * 
     */
    public function channel($sid)
    {
        $services = $this->client->chat->v2->services->read();
        
        $channels = $this->client->chat->v2->services($services[0]->sid)->channels->read();
        foreach ($channels as $record) {
            if ($record->sid == $sid) {
                $channel = $record;
            }
        }
        return view('chats/chat', compact('channel'));
    }
    /**
     * 
     */
    public function message($sid)
    {
        $services = $this->client->chat->v2->services->read();
        $messages = $this->client->chat->v2->services($services[0]->sid)->channels($sid)->messages->read();
        return view('chats/message', compact('messages'));
    }
    /**
     * 
     */
    public function member($sid)
    {
        $services = $this->client->chat->v2->services->read();
        $members = $this->client->chat->v2->services($services[0]->sid)->channels($sid)->members->read();
        return view('chats/member', compact('members'));
    }
    /**
     * 
     */
    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'message'   => 'required',
            'sid'  => 'required'
        ]);
        $services = $this->client->chat->v2->services->read();
        $message = $this->client->chat->v2->services($services[0]->sid)->channels($request['sid'])->messages->create(array("body" => $request['message'], "from" => Session::get('user.identity')));
        return response()->json(['success'=>'Message already send.']);
    }
}
