<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // GET
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subject = new Subject();
        $subject->name = $request->name;
        $subject->grade = $request->grade;
        $subject->group = $request->group;
        $subject->profesor = $request->profesor;
        $subject->begin_schedule = $request->begin_schedule;
        $subject->end_schedule = $request->end_schedule;
        $subject->album_id = $request->album_id;
        $subject->save();
        return $subject;

        // return Subject::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */

    public function show(Subject $subject){
        $res = Subject::find($subject);
        return $res;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        // PUT - PATCH
        $subject->update($request->all());
        // $subject->name->update($request->name);
        // $subject->grade->update($request->grade);
        // $subject->group->update($request->group);
        // $subject->profesor->update($request->profesor);
        // $subject->begin_schedule->update($request->begin_schedule);
        // $subject->end_schedule->update($request->end_schedule);
        // $subject->album_id->update($request->album_id);
        return $subject;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        // DELETE
        $subject->delete();
        return "Usuario Eliminado";
    }
}
