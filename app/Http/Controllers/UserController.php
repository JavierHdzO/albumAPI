<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = User::paginate(10);
        if (!$user) {
            return response([
                'status' => 'failed',
                'message' => 'No hay usuarios para mostrar'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'next_page' => $user->nextPageUrl(),
            'data' => $user->items()
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Obtiene un usuario por su identificador
        $user = User::find($id);
        if (!$user) {
            return response([
                'status' => 'failed',
                'message' => 'No existe el usuario'
            ]);
        }
        return  response([
            'status' => 'success',
            'data' => ['users' => $user]
        ]);;
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
        /**
         * El usuario solo tiene permitido modificar su propia información
         */
        $bearerToken = $request->bearerToken();
        $idUser = explode("|", $bearerToken)[0];
        // return response([
        //     'status' => 'failed',
        //     'message' => 'No tienes permiso de editar esto',
        //     'id'=>$id,
        //     'idUser' => $idUser,
        //     'tf' => $id != $idUser
        // ]);
        if($id != $idUser){
            return response([
                'status' => 'failed',
                'message' => 'No tienes permiso de editar esto',
                'id'=>$id,
                'idUser' => $idUser
            ]);
        }
        $user = User::find($id);
        if (!$user) {
            return response([
                'status' => 'failed',
                'message' => 'No existe el usuario'
            ]);
        }

        try {
            // return response()->json(['request' => $request->name]);
            $user->name = $request->name != null ? $request->name : $user->name;
            $user->email = $request->email != null ? $request->email: $user->email;
            $user->password = $request->password != null ? $request->password : $user->password;
            // return  response([
            //     $userID,
            //     $userKey,
            //     $created_at,
            //     $updated_at
            // ]);
            $user->save();

            return  response([
                'status' => 'success',
                'data' => ['users' => $user]
            ]);
        } catch (\Error $e) {
            return response([
                'status' => 'failed',
                'message' => 'Hubo un problema al actualizar la información del usuario',
                'error' => $e->getMessage()
            ]);
        }
        /**
         * Se excluyen valores que probablemente un usuario pueda ingresar
         */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Elimina a un usuario
        $user = User::find($id);
        try {
            if (!$user) {
                return response([
                    'status' => 'failed',
                    'message' => 'No existe el usuario'
                ]);
            }
            $user->delete();
            return  response([
                'status' => 'success',
                'data' => ['users' => $user]
            ]);;
        } catch (\Error $e) {
            return response([
                'status' => 'failed',
                'message' => 'No existe el usuario',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * obtiene todos los albums de un solo usuario
     */

    public function getAlbums(Request $request, $id)
    {
        /**
         * El usuario solo puede ver sus albumes(materias) propias
         */
        $bearerToken = $request->bearerToken();
        $idUser = explode("|", $bearerToken)[0];
        if($id != $idUser){
            return response([
                'status' => 'failed',
                'message' => 'No tienes permiso de ver esto',
                'id'=>$id,
                'idUser' => $idUser
            ]);
        }
        $userAlbums = Subject::select('subjects.*')->join('users', 'subjects.user_id', '=', 'users.id')->where('users.id', '=', $id)->paginate(10);
        if (count($userAlbums) <= 0) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No existe el usuario, o no tiene materias para mostrar'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'next_page' => $userAlbums->nextPageUrl(),
            'data' => $userAlbums->items()
        ]);
    }

    /**
     * Obtiene un album en especifico de un solo usuario
     */
    public function getAlbum(Request $request ,$userID, $albumID)
    {
        /**
         * El usuario solo puede ver sus albumes(materias) propias
         */
        $bearerToken = $request->bearerToken();
        $idUser = explode("|", $bearerToken)[0];
        if($userID != $idUser){
            return response([
                'status' => 'failed',
                'message' => 'No tienes permiso de ver esto',
                'id'=>$userID,
                'idUser' => $idUser
            ]);
        }

        $userAlbum = Subject::select('subjects.*')->join('users', 'subjects.user_id', '=', 'users.id')
            ->where('users.id', '=', $userID)
            ->where('subjects.id', '=', $albumID)
            ->get()
            ->first();
        if (!$userAlbum) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No existe el usuario, o no tiene materias para mostrar'
            ]);
        }
        return  response([
            'status' => 'success',
            'data' => ['userAlbum' => $userAlbum]
        ]);;
    }
}
