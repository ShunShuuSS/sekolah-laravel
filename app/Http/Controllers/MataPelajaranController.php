<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataMataPelajaran = MataPelajaran::all();

        return $dataMataPelajaran;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $this->AutoIncrementId();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return [
                'message' => 'Error',
                'error' => $validator->errors(),
            ];
        }

        $name = $request->name;
        $description = $request->description;

        $response =  DB::insert(
            'insert into mata_pelajaran (id_mata_pelajaran, name, description)
            values (?, ?, ?)', [$id, $name, $description]);
        
        if($response == 1){
            return [
                'message' => 'Store data success'
            ];
        }else{
            return[
                'message' => 'Store data error'
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
        $target = MataPelajaran::where('id_mata_pelajaran', $id)->first();
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
            'name' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return [
                'message' => 'Error',
                'error' => $validator->errors(),
            ];
        }

        $name = $request->name;
        $description = $request->description;

        $response = DB::update(
            'update mata_pelajaran set name = ?, description = ? where id_mata_pelajaran = ?',
            [$name, $description, $id]
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
        $target = MataPelajaran::where('id_mata_pelajaran', $id)->first();

        if(!$target){
            return [
                'message' => 'no target found'
            ];
        }
        
        $response = DB::table('mata_pelajaran')
            ->where('id_mata_pelajaran', $id)
            ->delete();

        if($response == 1){
            return [
                'message' => 'Delete data success'
            ];
        }else{
            return [
                'message' => 'Delete data error'
            ];
        }
    }

    private function AutoIncrementId(){
        $getLastData = MataPelajaran::orderBy('id_mata_pelajaran', 'desc')->first();

        $getId = $getLastData['id_mata_pelajaran'];

        $getIdInt = substr($getId, 2);

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

        $createNewId = 'MP' . $createId . (string)$getIdInt;

        return $createNewId;
    }
}
