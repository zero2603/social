<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event as EventModel;
use App\EventSchedules as EventSchedulesModel;
use DateTime;
use Session;
use URL;
use App\Agency;

class Event extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listEvent()
    {
        $events = EventModel::getItems(array());
        $agency = Agency::all();
        return view('admin.event.list-event', [
            'items' => $events,
            'agencies' => $agency
        ]);
    }

    public function editEvent($id){
        $item = EventModel::getItem($id);
        return view('admin.event.edit-event', [
            'item' => $item
        ]);
    }

    public function listEventSchedules()
    {
        $events = EventSchedulesModel::paginate(20);
        return view('admin.event.list-event-schedules', ['items' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_event = $request->get('data');
        $new_event['start_date'] = date_format(new DateTime($new_event['start_date']), 'm-d-Y');
        $new_event['start_date'] = substr($new_event['start_date'], 0, 5);

        EventSchedulesModel::create($new_event);

        return redirect('/admin?view=Event&layout=listEventSchedules');
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
        $event = EventSchedulesModel::find($id);

        // show the view and pass the nerd to it
        return view('admin.event.detail', ['item' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id =  $request->input('id');
        $event = EventSchedulesModel::find($id);
        $data = $request->get('data');

        foreach ($data as $key => $value) {
            $event->$key = $value;
        }

        $event->save();
        return redirect('admin?view=Event&layout=listEventSchedules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id =  $request->input('id');
        EventSchedulesModel::destroy($id);
        // redirect to previous url after destroy
        Session::put('pre_url', URL::previous());
        console_log(Session::get('pre_url'));
        return redirect(Session::get('pre_url'));
    }

    public function approve(Request $request){
        $id =  $request->input('id');
        $item = EventModel::find($id);
        if (!$item->id){
            return redirect()->back()->withErrors(['failed' => 'Đã có lỗi xảy ra, vui lòng thử lại']);
        }

        $item->is_approved = 1;
        $result = $item->save();
        if ($result){
            return redirect()->back()->with('success', [__('admin.SAVE_SUCCESS')]);
        }else{
            return redirect()->back()->withErrors(__('admin.SAVE_FAIL'));
        }

    }
}
