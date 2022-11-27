<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\registerRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class authController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum', ['only' => ['logout']]);
        // $this->middleware('guest', ['only' => ['store', 'login']]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(registerRequest $request)
    {
        
        //Registra un nuevo usuario
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            return response()->json([
                'success' => true, 
                'message' => 'Usuario registrado correctamente',
            ]);
        } catch (\Error $e) {
            return response()->json([
                'success' => false, 
                'message' => 'No se pudo registrar al usuario', 
                "error" => $e->getMessage()
            ]);
        }
    }

    public function login(Request $request){
        //obtiene los datos del request y ejecuta attempt para buscar si las credenciales coinciden

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            return response()->json([
                'success'=> false, 
                'message'=>'Usuario no encontrado',
                '0'=> $request->email,
                '1' =>$request->password
            ]);
        }
        //trae el id del usuario y genera una key para protección de rutas.
        $userID = User::select('id')->where('email', $request->email)->get()->first()['id'];
        $key = $userID."|".Str::random(20);
        $user = User::find($userID);
        $user->key = $key;
        $user->save();

        // response()->header('Authorization', 'Bearer'.$key);

        // $cookie = cookie('cookie_token', $token, 60 * 24);
        // return response(["token"=>$token],)->withoutCookie($cookie);

        /**EL TOKEN OBTENIDO EN EL RESPONSE DEBE SER PUESTO EN EL HEADER COMO AUTHORIZATION */
        return response()->json([
            'success' => true, 
            'email' => $request->email, 
            'token' => $key,
            'id' => $userID
        ]);
    }


    /**
     * Destroy session
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        //
        try{

            return response()->json([
                'success' => true, 
                'message' => 'Sesión cerrada'
            ]);
        }catch(\Error $e){
            return response()->json([
                'success' => false, 
                'message' => 'Hubo un error', "
                error" => $e->getMessage()
            ]);
        }
    }
}
