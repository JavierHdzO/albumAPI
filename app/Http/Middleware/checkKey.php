<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \App\Models\User;

class checkKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $key = request()->bearerToken();
        if(!$key){
            return response()->json([
                'success' => false,
                'message' => 'Inicie sesión'
            ]);
        }
        // return response()->json(['1' => $key]);
        $idUser = explode("|",$key)[0];

        //comprobación de id y key
        $userHasKey = User::where([['id','=', $idUser],['key', '=', $key]])->get()->first();
        if(!$userHasKey){
            return response()->json([
                'success' => false,
                'message' => 'Inicie sesión'
            ]);
        }
        // return response()->json(['1' => $userHasKey, '2'=>$key, '3'=>$idUser] );
        $request->headers->add(["key" => $key, "idUser"=>$idUser]);
        return $next($request);
    }
}
