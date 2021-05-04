<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataRole = Role::all();

        return $dataRole;
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
            'name' => 'required',
            'description' => 'required'
        ]);

        $id_role = 
        $name = $request->name;
        $description = $request->description;

        DB::insert('insert into role (id_role, name, description) values (?, ?, ?)', [1, 'Dayle'])

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $target = Role::where('id_role', $id)->first();

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

    private function AutoIncrementId(){
        $getLastData = Role::orderBy('id_role', 'desc')->first();

        $getId = $getLastData['id_role'];

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

        $createNewId = 'R' . $createId . (string)$getIdInt;

        return $createNewId;
    }
}
