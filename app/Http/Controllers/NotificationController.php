<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataNotification = Notification::all();

        return $dataNotification;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_id_user' => 'required',
            'to_id_user' => 'required',
            'message' => 'required',
        ]);

        if($validator->fails()){
            return [
                'message' => 'Error',
                'error' => $validator->errors(),
            ];
        }

        $from_id_user = $request->from_id_user;
        $to_id_user = $request->to_id_user;
        $message = $request->message;

        $response =  DB::insert(
            'insert into notification (from_id_user, to_id_user, message)
            values (?, ?, ?)',
            [$from_id_user, $to_id_user, $message]
        );
        
        if($response == 1){
            return [
                'message' => 'Store data notification success'
            ];
        }else{
            return[
                'message' => 'Store data notification error'
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $target = Notification::where('id_notification', $id)->first();

        if(!$target){
            return [
                'message' => 'no data found'
            ];
        }
        return $target;
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
        $validator = Validator::make($request->all(), [
            'read' => 'required',
        ]);

        if($validator->fails()){
            return [
                'message' => 'Error',
                'error' => $validator->errors(),
            ];
        }

        $read = true;

        $response = DB::update(
            'update notification
            set read = ?
            where id_mata_pelajaran = ?',
            [$read, $id]
        );

        if($response == 1){
            return [
                'message' => 'Update data success'
            ];
        }else{
            return [
                'message' => 'Update data error'
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = DB::table('notification')
            ->where('id_notification', $id)
            ->delete();

        if($response){
            return [
                'message' => 'Delete data notification success'
            ];
        }else{
            return [
                'message' => 'Delete data notification error'
            ];
        }
    }
}
