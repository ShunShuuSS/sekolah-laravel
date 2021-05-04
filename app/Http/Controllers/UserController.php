<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataUser = User::all();

        return $dataUser;
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
            'email' => ['required', 'email'],
            'password' => 'required',
            'name' => 'required',
            'birthdate' => 'required',
            'id_role' => 'required',
            'link_foto' => 'required',
            'izin_edit' => 'required'
        ]);

        if($validator->fails()){
            return [
                'message' => 'Error',
                'error' => $validator->errors(),
            ];
        }

        $id_user = $this->AutoIncrementId();
        $email = $request->email;
        $password = $request->password;
        $name = $request->name;
        $birthdate = $request->birthdate;
        $id_role = $request->id_role;
        $link_foto = $request->link_foto;
        $izin_edit = $request->izin_edit;

        $response = DB::insert('insert into user (id_user, email, password, name, birthdate, id_role, link_foto, izin_edit)
                values (?, ?, ?, ?, ?, ?, ?, ?)', [$id_user, $email, $password, $name, $birthdate, $id_role, $link_foto, $izin_edit]);

        if($response == 0){
            return [
                'message' => 'Store data user error',
            ];
        }

        if($id_role == "R0002"){
            $storeGuru = (new GuruController)->store($name, $id_user);

            if($storeGuru == 0){
                return [
                    'message' => 'Store data guru error',
                ];
            }
        }

        if($id_role == "R0003"){
            $storeMurid = (new MuridController)->store($name, $id_user);

            if($storeMurid == 0){
                return [
                    'message' => 'Store data murid error',
                ];
            }
        }

        return [
            'message' => 'Store data success'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $target = User::where('id_user', $id)->first();

        return $target;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_user)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => 'required',
            'name' => 'required',
            'birthdate' => 'required',
            'id_role' => 'required',
            'link_foto' => 'required',
            'izin_edit' => 'required'
        ]);

        $id_role = $this->getUserIdRole($id_user);
        $email = $request->email;
        $password = $request->password;
        $name = $request->name;
        $birthdate = $request->birthdate;
        $link_foto = $request->link_foto;

        $response = DB::update('update user
            set
                email = ?,
                password = ?,
                name = ?,
                birthdate = ?,
                link_foto = ?
            where id_user = ?',
        [$email, $password, $name, $birthdate, $link_foto, $id_user]);

        if($response == 0){
            return [
                'message' => 'Update data user error'
            ];
        }

        if($id_role == 'R0002'){
            $updateGuru = (new GuruController)->update($name, $id_user);

            if($updateGuru == 0){
                return [
                    'message' => 'Update data guru error'
                ];
            }
        }

        if($id_role == 'R0003'){
            $updateMurid = (new MuridController)->update($name, $id_user);

            if($updateMurid == 0){
                return [
                    'message' => 'Update data murid error'
                ];
            }
        }

        return [
            'message' => 'Update data user success'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_user)
    {
        $checkIdRole = $this->getUserIdRole($id_user);

        if($checkIdRole == "R0002"){
            $deleteGuru = (new GuruController)->destroy($id_user);

            if($deleteGuru == 0){
                return [
                    'message' => 'Delete guru error'
                ];
            }
        }

        if($checkIdRole == "R0003"){
            $deleteMurid = (new MuridController)->destroy($id_user);

            if($deleteMurid == 0){
                return [
                    'message' => 'Delete murid error'
                ];
            }
        }

        $response = DB::table('user')->where('id_user', $id_user)->delete();

        if($response){
            return [
                'message' => 'Delete data user success'
            ];
        }else{
            return [
                'message' => 'Delete data user error'
            ];
        }
    }

    private function AutoIncrementId(){
        $getLastData = User::orderBy('id_user', 'desc')->first();

        $getId = $getLastData['id_user'];

        $createNewId = $getId + 1;

        return $createNewId;
    }

    private function getUserIdRole($id){
        $getId = User::where('id_user', $id)->first();

        $getIdRole = $getId['id_role'];

        return $getIdRole;
    }
}
