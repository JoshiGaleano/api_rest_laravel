<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notificaciones;
use App\Usuario;

class NotificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Notificaciones::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notificacion = Notificaciones::where('id', $id)->first();
        $user = Usuario::select('token')->get();

        if($user != null){
            $tokens = [];
            foreach($user as $r){
                array_push($tokens, $r->token);
            }

            // API access key from Google API's Console

            //FCM API end-point
           $url = 'https://fcm.googleapis.com/fcm/send';
           //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
           $server_key = 'AAAAU5zK6Fc:APA91bEi7UiVDrDsiS-ZKVW9wbREdBLyZ_R8mAsL9EoPVSJdvInJPcemaZRYbtEuBmZeMv49f1BFd4rFguVfKbyFW1CpNB2ZL5ZXLpmq0tPSEaQyWcju6onPUqLulmRrWqkxj-SIbUGM';
           $target = $tokens;
                    
           $fields = array();
           $fields['notification']['title'] = $notificacion->titulo;
           $fields['notification']['body'] = $notificacion->subtitulo;
           $fields['notification']['sound'] = 'default';
           $fields['notification']['click_action'] = 'ACTIVITY_NOTIFICACION';
           $fields['data'] = $notificacion;
           if(is_array($target)){
            $fields['registration_ids'] = $target;
           }else{
            $fields['to'] = $target;
           }
           //header with content_type api key
           $headers = array(
            'Content-Type:application/json',
                'Authorization:key='.$server_key
           );
           //CURL request to route notification to FCM connection server (provided by Google)           
           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL, $url);
           curl_setopt($ch, CURLOPT_POST, true);
           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
           $result = curl_exec($ch);
           if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
           }
           curl_close($ch);

           return $result;
        }

        //revisar url parametros notificacion https://firebase.google.com/docs/cloud-messaging/http-server-ref
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
