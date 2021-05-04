<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MuridController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentData = Murid::all();

        return $studentData;
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

        $response = DB::insert('insert into murid (id_murid, name, id_user) values (?, ?, ?)', [$id, $name, $id_user]);

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
        $target = Murid::where('id_murid', $id)->first();
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
        $response = DB::update('update murid set name = ? where id_user = ?', [$name, $id_user]);

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
        $response = DB::table('murid')->where('id_user', $id_user)->delete();

        return $response;
    }

    private function AutoIncrementId(){
        $getLastData = Murid::orderBy('id_murid', 'desc')->first();

        $getId = $getLastData['id_murid'];

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

        $createNewId = 'M' . $createId . (string)$getIdInt;

        return $createNewId;
    }
}
