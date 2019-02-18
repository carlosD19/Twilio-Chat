<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChannelRequest;
use Twilio\Rest\Client;

class ChannelController extends Controller
{

    protected $client;

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
        if (!$services) {
            $service = $this->client->chat->v2->services->create("Twilio-Chat");
            $services = $this->client->chat->v2->services->read();
        }
        $channels = $this->client->chat->v2->services($services[0]->sid)->channels->read();
        return view('channels.index', compact('channels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('channels.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ChannelRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChannelRequest $request)
    {
        $services = $this->client->chat->v2->services->read();

        $channel = $this->client->chat->v2->services($services[0]->sid)->channels->create(array("friendlyName" => $request['name']));
        return redirect()->route('channels.index')->with('info', 'Saved channel.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($sid)
    {
        $services = $this->client->chat->v2->services->read();
        $channels = $this->client->chat->v2->services($services[0]->sid)->channels->read();
        foreach ($channels as $record) {
            if ($record->sid === $sid) {
                $channel = $record;
            }
        }
        return view('channels.edit', compact('channel', 'channels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ChannelRequest  $request
     * @param  int  $sid
     * @return \Illuminate\Http\Response
     */
    public function update(ChannelRequest $request, $sid)
    {
        $services = $this->client->chat->v2->services->read();
        $channel = $this->client->chat->v2->services($services[0]->sid)->channels($sid)->update(array("friendlyName" => $request['name']));
        return redirect()->route('channels.index')->with('info', 'Channel already modified.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sid)
    {
        $services = $this->client->chat->v2->services->read();
        $this->client->chat->v2->services($services[0]->sid)->channels($sid)->delete();
        return back()->with('info', 'The channel was eliminated.');
    }
}
