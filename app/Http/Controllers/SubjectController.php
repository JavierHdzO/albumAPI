<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Photo;
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
        $paginate = Subject::paginate(5);
        return response()->json([
            'status' => 'success',
            'data'  => [
                'total' => $paginate->total(),
                'subjects' => $paginate->items(),
                'next_page' => $paginate->nextPageUrl()
            ]
            ],
            200,
            [],
            JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT
        
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, /* $userID */)
    {
        // Registra un nuevo subject
        try {
            
            // Obtener ID por el token de autenticacion
            $userID = User::select('id')->where('key', explode(' ',$request->header('Authorization'))[1])->get()->first()['id'];

            // Generar nuevo subject
            $subject = new Subject();
            $subject->name = $request->name;
            $subject->grade = $request->grade;
            $subject->group = $request->group;
            $subject->professor = $request->professor;
            $subject->start_scheule = $request->start_scheule;
            $subject->end_schedule = $request->end_schedule;
            $subject->user_id = $userID;
            $subject->save();
            return response()->json([
                'success' => true,
                'message' => 'Subject registered correctly',
            ]);
        } catch (\Error $e) {
            return response()->json([
                'success' => false,
                'message' => 'Subject was not added',
                "error" => $e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show($userID)
    {
        $subject = Subject::select('id', 'name', 'grade', 'group', 'professor', 'start_scheule', 'end_schedule')->where('user_id', $userID)->get()->all();
        if ($subject)
        {
            return response()->json([
                'success' => true,
                'subjects' => $subject
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'No subjects related to current user'
            ]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subjectID)
    {   
        try{
            $subject = Subject::find($subjectID);
            $subject->name = $request->name != null ? $request->name : $subject->name;
            $subject->grade = $request->grade != null ? $request->grade : $subject->grade;
            $subject->group = $request->group != null ? $request->group : $subject->group;
            $subject->professor = $request->professor != null ? $request->professor : $subject->professor;
            $subject->start_scheule = $request->start_scheule != null ? $request->start_scheule : $subject->start_scheule;
            $subject->end_schedule = $request->end_schedule != null ? $request->end_schedule : $subject->end_schedule;
            $subject->save();
            
            return response([
                'success'=> true,
                'message'=> 'Subject updated correctly',
                'data'=> $subject
            ]);
        }
        catch (\Error $e) {
            return response([
                'success' => false,
                'message' => 'Trouble while updating subject',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy($subjectID)
    {
        try{
            $subject = Subject::find($subjectID);
            Photo::select('photos.*')->where('subject_id', $subjectID)->delete();
            $subject->delete();
            return response([
                'success'=> true,
                'message'=> 'Subject with ID = '.$subjectID.' was successfully deleted'
            ]);
        } 
        catch(\Error $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
