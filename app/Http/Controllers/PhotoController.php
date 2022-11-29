<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = Photo::paginate(10);
        return response()->json([
            'status' => 'success',
            'data'  => [
                'total' => $paginate->total(),
                'photos' => $paginate->items(),
                'next_page' => $paginate->nextPageUrl()
            ]
            ],
            200,
            [],
            JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT
        
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePhotoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhotoRequest $request)
    {
        
        //$photo = $request->file('photo')->store('images');
        if(!$request->hasFile('photo')){
            return response()->json([
                'status' => 'Error',
                'message' => 'File not found'
            
            ]);
        }

        $secure_url = cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath();

        $photo  = Photo::create([
            'url' => $secure_url,
            'type' => $request->type,
            'status' => $request->status,
            'schedule' => $request->schedule,
            'subject_id' => $request->subject
        ]);

    
        

        return response()->json([
            'status' => 'success',
            'data' => $photo
            ],
            200,
            [],
            JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'photo' => $photo
            ]
        ],
        200,
        [],
        JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhotoRequest  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhotoRequest $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {

        if($photo == null){
            return response()->json([
                'status' => 'Error',
                'message' => 'Photo not found'
            ]);
        }

        $secure_id = $photo->url;
        $secure_id = explode('/', $secure_id);
        $keyImage = $secure_id[count($secure_id) - 1];
        $keyImage = explode('.', $keyImage);
        $keyImage = $keyImage[0];

        cloudinary()->destroy($keyImage);
       
        $photo->delete();
        return response()->json([
            'status' => 'success',
            'data'=>[
                'photo' => $photo
            ]
        ],
        200,
        [],
        JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT
        );
    }
}
