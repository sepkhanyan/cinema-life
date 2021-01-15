<?php

namespace App\Http\Controllers;

use App\Cinema;
use App\Hall;
use App\Http\Requests\SessionStoreRequest;
use App\Movie;
use App\Session;

class SessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = Session::query()->with('movie.cinema', 'hall')->get();

        return view('sessions.index', ['sessions' =>  $sessions]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cinemas = Cinema::all();
        $movies = Movie::all();
        $halls = Hall::all();

        if(!count($cinemas)){
            session(['not_created' => 'You has not created Cinema yet.']);
            return view('cinemas.create');
        }

        if(!count($halls)){
            session(['not_created' => 'You has not created Hall yet.']);
            return view('halls.create', ['cinemas' =>  $cinemas]);
        }

        if(!count($movies)){
            session(['not_created' => 'You has not created Movie yet.']);
            return view('movies.create', ['cinemas' =>  $cinemas]);
        }

        return view('sessions.create', ['halls' => $halls,'movies' =>  $movies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SessionStoreRequest $request)
    {
        $data = $request->only('movie_id', 'hall_id', 'start_time', 'end_time');

        $movie = Movie::find($data['movie_id']);
        $sessionTime = (strtotime($data['end_time']) - strtotime($data['start_time'])) / 60;
        $movieDuration = $movie['duration'];


        if($sessionTime < $movieDuration){
            session(['active_session' => 'Session time must be bigger than movie duration.']);
            return redirect()->back();
        }


        $lastSession = Session::where('hall_id', $data['hall_id'])->orderBy('end_time', 'desc')->first();

        if($lastSession){
            if($lastSession['end_time'] > $data['start_time']){
                session(['active_session' => 'Session must start after last session.']);
                return redirect()->back();
            }

            $break = (strtotime($lastSession['end_time']) - strtotime($data['start_time'])) / 60;

            if($break < 15){
                session(['active_session' => 'Between sessions should pass at least 15 minutes.']);
                return redirect()->back();
            }

        }
        $session = Session::create($data);

        return redirect('/sessions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        $session->load('movie.cinema', 'hall');

        return view('sessions.show', ['session' =>  $session]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Session $session)
    {
        $movies = Movie::all();
        $halls = Hall::all();

        return view('sessions.edit', ['session' => $session,'halls' => $halls,'movies' =>  $movies]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(SessionStoreRequest $request, Session $session)
    {
        $data = $request->only('movie_id', 'hall_id', 'start_time', 'end_time');

        $movie = Movie::find($data['movie_id']);
        $sessionTime = (strtotime($data['end_time']) - strtotime($data['start_time'])) / 60;
        $movieDuration = $movie['duration'];


        if($sessionTime < $movieDuration){
            session(['active_session' => 'Session time must be bigger than movie duration.']);
            return redirect()->back();
        }


        $lastSession = Session::where('hall_id', $data['hall_id'])
            ->where('id', '!=' , $session['id'])
            ->orderBy('end_time', 'desc')->first();

        if($lastSession){
            if($lastSession['end_time'] > $data['start_time']){
                session(['active_session' => 'Session must start after last session.']);
                return redirect()->back();
            }

            $break = (strtotime($data['start_time']) - strtotime($lastSession['end_time'])) / 60;

            if($break < 15){
                session(['active_session' => 'Between sessions should pass at least 15 minutes.']);
                return redirect()->back();
            }

        }

        $session->update($data);

        return redirect('/sessions');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        $session->delete();

        return redirect('/sessions');
    }
}
