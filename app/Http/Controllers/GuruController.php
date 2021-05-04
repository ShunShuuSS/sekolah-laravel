<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataGuru = Guru::all();

        return $dataGuru;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($name, $id_user)
    {
        $id = $this->AutoIncrementId();

        $response = DB::insert('insert into guru (id_guru, name, id_user) values (?, ?, ?)', [$id, $name, $id_user]);

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $target = Guru::where('id_guru', $id)->first();
        
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
    public function update($name, $id_user)
    {
        $response = DB::table('guru')->where('id_user', $id_user)->delete();

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_user)
    {
        $response = DB::delete('delete guru where id_user = ?', [$id_user]);

        return $response;
    }

    private function AutoIncrementId(){
        $getLastData = Guru::orderBy('id_guru', 'desc')->first();

        $getId = $getLastData['id_guru'];

        $getIdInt = substr($getId, 1);

        $zeroCount = 0;

        while(true){
            if(substr($getIdInt, 0, 1) != '0'){
                break;
            }
            $getIdInt = substr($getIdInt, 1);
            $zeroCount++;
        }

        $checkLengthIdInt = strlen($getIdInt);
        $getIdInt = $getIdInt + 1;
        if(strlen($getIdInt) != $checkLengthIdInt){
            $zeroCount--;
        }

        $createId = '';

        while($zeroCount != 0){
            $createId = $createId . '0';
            $zeroCount--;
        }

        $createNewId = 'G' . $createId . (string)$getIdInt;

        return $createNewId;
    }
}
