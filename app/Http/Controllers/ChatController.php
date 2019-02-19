<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Session;

class ChatController extends Controller
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
    }

    /**
     * In this method list channels and userChannels
     *
     * @return \Illuminate\Http\Response the chats view
     */
    public function index()
    {
        $services = $this->client->chat->v2->services->read();
        $channels = array();
        $userChannels = array();
        if ($services) {
            $channels = $this->client->chat->v2->services($services[0]->sid)->channels->read();
            if (Session::has('user')) {
                $userChannels = $this->client->chat->v2->services($services[0]->sid)->users(Session::get('user.sid'))->userChannels->read();
            }
        }
        return view('chats.index', compact('channels', 'userChannels'));
    }
    /**
     * In this method is to join in a new channel
     *
     * @param  $sid of the channel
     * @return back the view
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
     * In this method is to join the chat
     *
     * @param  $sid of the channel
     * @return the chat view
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
     * In this method it is to get messages from the channel
     *
     * @param  $sid of the channel
     * @return the message view
     */
    public function message($sid)
    {
        $services = $this->client->chat->v2->services->read();
        $messages = $this->client->chat->v2->services($services[0]->sid)->channels($sid)->messages->read();
        return view('chats/message', compact('messages'));
    }
    /**
     * In this method it is to get members from the channel
     *
     * @param  $sid of the channel
     * @return the member view
     */
    public function member($sid)
    {
        $services = $this->client->chat->v2->services->read();
        $members = $this->client->chat->v2->services($services[0]->sid)->channels($sid)->members->read();
        return view('chats/member', compact('members'));
    }
    /**
     * In this method is to send messages to the channel
     *
     * @param  \Illuminate\Http\Request $request receive the message and channel´s sid
     * @return \Illuminate\Http\Response back the view
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
