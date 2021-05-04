<?php

namespace App\Http\Controllers;

use App\Models\AlokasiKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AlokasiKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataAlokasiKelas = AlokasiKelas::all();

        return $dataAlokasiKelas;
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
            'id_kelas' => 'required',
            'id_murid' => 'required',
            'id_guru' => 'required',
            'id_mata_pelajaran' => 'required',
        ]);

        if($validator->fails()){
            return [
                'error' => $validator->errors()
            ];
        }
        
        $id_kelas = $request->id_kelas;
        $id_murid = $request->id_murid;
        $id_guru = $request->id_guru;
        $id_mata_pelajaran = $request->id_mata_pelajaran;
        $nilai_tugas = $request->nilai_tugas;
        $nilai_uts = $request->nilai_uts;
        $nilai_uas = $request->nilai_uas;
        

        $column = 'id_kelas, id_murid, id_guru, id_mata_pelajaran';
        $values = '?, ?, ?, ?';
        $dataArray = [
            $id_kelas,
            $id_murid,
            $id_guru,
            $id_mata_pelajaran,
        ];

        if($nilai_tugas){
            $column .= ', nilai_tugas';
            $values .= ', ?';
            array_push($dataArray, $nilai_tugas);
        }

        if($nilai_uts){
            $column .= ', nilai_tugas';
            $values .= ', ?';
            array_push($dataArray, $nilai_uts);
        }

        if($nilai_uas){
            $column .= ', nilai_uas';
            $values .= ', ?';
            array_push($dataArray, $nilai_uas);
        }

        if($nilai_tugas != 0 &&  $nilai_uts != 0 && $nilai_uas !=0){
            $nilai_akhir = 0.3 * $nilai_tugas + 0.3 * $nilai_uts + 0.4 * $nilai_uas;
            $column .= ', nilai_akhir';
            $values .= ', ?';
            array_push($dataArray, $nilai_akhir);
            
        }

        $response = DB::insert(
            "insert into alokasi_kelas ($column)
            values ($values)",
            $dataArray
        );

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
        $target = AlokasiKelas::where('id_alokasi', $id);

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
            'id_kelas' => 'required',
            'id_murid' => 'required',
            'id_guru' => 'required',
            'id_mata_pelajaran' => 'required',
        ]);

        if($validator->fails()){
            return [
                'error' => $validator->errors()
            ];
        }
        
        $id_kelas = $request->id_kelas;
        $id_murid = $request->id_murid;
        $id_guru = $request->id_guru;
        $id_mata_pelajaran = $request->id_mata_pelajaran;
        $nilai_tugas = $request->nilai_tugas;
        $nilai_uts = $request->nilai_uts;
        $nilai_uas = $request->nilai_uas;
        
        $column = 'id_kelas = ?, id_murid = ?, id_guru = ?, id_mata_pelajaran = ?';
        $dataArray = [
            $id_kelas,
            $id_murid,
            $id_guru,
            $id_mata_pelajaran,
        ];

        if($nilai_tugas){
            $column .= ', nilai_tugas = ?';
            array_push($dataArray, $nilai_tugas);
            // return $nilai_tugas;
        }

        if($nilai_uts){
            $column .= ', nilai_tugas = ?';
            array_push($dataArray, $nilai_uts);
            // return $nilai_uts;
        }

        if($nilai_uas){
            $column .= ', nilai_uas = ?';
            array_push($dataArray, $nilai_uas);
            // return $nilai_uas;
        }

        if($nilai_tugas != 0 && $nilai_uts != 0 && $nilai_uas !=0){
            $nilai_akhir = (double)(0.3 * $nilai_tugas) + (double)(0.3 * $nilai_uts) + (double)(0.4 * $nilai_uas);
            $column .= ', nilai_akhir = ?';
            array_push($dataArray, $nilai_akhir);
            // return $nilai_akhir;
        }

        $response = DB::update(
            "update alokasi_kelas
            set $column
            where id_alokasi = ?",
            [...$dataArray, $id]
        );

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = DB::table('alokasi_kelas')->where('id_alokasi', $id)->delete();

        return $response;
    }
}
