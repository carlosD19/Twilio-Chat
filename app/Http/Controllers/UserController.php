<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Session;

class UserController extends Controller
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response the login view
     */
    public function index()
    {
        return view('security.login');
    }
    /**
     * In this method it is verify that the username and password are correct
     *
     * @param  \Illuminate\Http\Request $request receive the username and password
     * @return \Illuminate\Http\Response the view of the respective user
     */
    public function login(Request $request)
    {
        $this->validate($request, [
        'usernameLogin'   => 'required',
        'passwordLogin'  => 'required'
        ]);

        $services = $this->client->chat->v2->services->read();
        if ($services) {
            $users = $this->client->chat->v2->services($services[0]->sid)->users->read();
            foreach ($users as $record) {
                $password = json_decode($record->attributes, true);
                if ($record->identity == $request['usernameLogin'] && $password['password'] == $request['passwordLogin']) {
                    $user = array('sid' => $record->sid, 'identity' => $record->identity);
                    Session::put('user', $user);
                    return redirect('chats');
                }
            }
        }
        if ($request['usernameLogin'] == 'admin' && $request['passwordLogin'] == 'admin') {
            $user = array('identity' => 'Administrator');
            Session::put('user', $user);
            return redirect('channels');
        } else {
            return back()->with('info', 'Username or SID invalid.');
        }
    }
    /**
     * In this method a new user is registered
     *
     * @param  \Illuminate\Http\Request $request receive the username, password and password confirm
     * @return \Illuminate\Http\Response the view of the respective user
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'usernameSignup' => 'required',
            'passwordSignup'  => 'required|alphaNum|min:3',
            'passwordConfirm' => 'required|same:passwordSignup'
        ]);

        $services = $this->client->chat->v2->services->read();
        if ($services) {
            $password = array("password" => $request['passwordSignup']);
            try {
                $user = $this->client->chat->v2->services($services[0]->sid)->users->
                create($request['usernameSignup'], array("attributes" => json_encode($password)));
                $user = array('sid' => $user->sid, 'identity' => $user->identity);
                Session::put('user', $user);
                return redirect('chats');
            } catch (\Throwable $e) {
                return back()->with('info', 'Username already exist.');
            }
        }
    }
    /**
     * In this method the user logout
     *
     * @return \Illuminate\Http\Response the login view
     */
    public function logout()
    {
        Session::flush();
        return redirect('');
    }
}
