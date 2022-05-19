<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = Event::when($request->eventType, function ($q) use ($request) {
            if ($request->eventType == "upcoming") {
                $q->whereDate('start_date', '>', \Carbon\Carbon::now());
            } else if ($request->eventType == "finished") {
                $q->whereDate('end_date', '<', \Carbon\Carbon::now());
            }
        })->orderBy('start_date')->paginate();
        return view('events.list', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:191',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        Event::create($validated);

        return redirect(route('events.index'))->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('events.form', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:191',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        Event::findOrFail($id)->update($validated);

        return redirect(route('events.index'))->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = $_GET['id'];
        $event = Event::find($id);
        if ($event) {
            $event->delete();
            return response()->json('success');
        } else {
            return response()->json('fail');
        }
    }

}
