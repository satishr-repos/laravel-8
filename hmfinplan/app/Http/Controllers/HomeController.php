<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facade as Debugbar;

class HomeController extends Controller
{
    private $debugbar;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        Debugbar::disable();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    public function debug()
    {
        Debugbar::info('Toggle Debug', $this->debugbar);
        if($this->debugbar == true)
        {
            $this->debugbar = false;
            Debugbar::disable();
        }
        else
        {
            $this->debugbar = true;
            DebugBar::enable();
        }

        $msg = ($this->debugbar == true) ? 'true' : 'false';

        return redirect()->back()->with('msg' , $msg);
    }
}
