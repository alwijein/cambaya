<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class DataGuruController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');


        // dd($all);

        if($id){
            $guru = Guru::with(['pelajaran'])->find($id);
            if($guru){
                return ResponseFormatter::success($guru, 'Data Berhasil Diambil');
            }else{
                return ResponseFormatter::error(null, 'Data Tidak Ada', 404);
            }
        }

        $guru = Guru::with(['pelajaran']);



        return ResponseFormatter::success(
            $guru->paginate($limit),
            'Data berhasil diambil'
        );
    }
}
