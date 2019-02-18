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
     * In this method create a new service if no exist
     *
     * @return \Illuminate\Http\Response the view channels with list of channels
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
     * In this method redirect to channels index
     *
     * @return \Illuminate\Http\Response the channels index view
     */
    public function create()
    {
        return redirect()->route('channels.index');
    }

    /**
     * In this method create a new channel
     *
     * @param  \Illuminate\Http\ChannelRequest $request receive the channel´s name
     * @return \Illuminate\Http\Response back the view
     */
    public function store(ChannelRequest $request)
    {
        $services = $this->client->chat->v2->services->read();

        $channel = $this->client->chat->v2->services($services[0]->sid)->channels->create(array("friendlyName" => $request['name']));
        return redirect()->route('channels.index')->with('info', 'Saved channel.');
    }

    /**
     * Show the form for editing the specified channel.
     *
     * @param  int  $sid of the channel
     * @return \Illuminate\Http\Response the edit view
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
     * Update the specified channel from twilio API.
     *
     * @param  \Illuminate\Http\ChannelRequest  $request receive the new channel´s name
     * @param  int  $sid of the old channel
     * @return \Illuminate\Http\Response the principal view
     */
    public function update(ChannelRequest $request, $sid)
    {
        $services = $this->client->chat->v2->services->read();
        $channel = $this->client->chat->v2->services($services[0]->sid)->channels($sid)->update(array("friendlyName" => $request['name']));
        return redirect()->route('channels.index')->with('info', 'Channel already modified.');
    }

    /**
     * Remove the specified channel from twilio API.
     *
     * @param  int  $sid of the channel
     * @return \Illuminate\Http\Response back the view
     */
    public function destroy($sid)
    {
        $services = $this->client->chat->v2->services->read();
        $this->client->chat->v2->services($services[0]->sid)->channels($sid)->delete();
        return back()->with('info', 'The channel was eliminated.');
    }
}
