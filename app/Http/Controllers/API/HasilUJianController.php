<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilUJianController extends Controller
{
    public function all(Request $request)
    {
        $semester = $request->input('semester');


        // dd($all);
            $siswa = Siswa::where('no_induk', Auth::user()->email)->first();

            $nilai = Nilai::with(['pelajaran', 'guru'])->where('kode_siswa', $siswa->id)->where('semester', $semester)->get();

            if($nilai){
                return ResponseFormatter::success($nilai, 'Data Berhasil Diambil');
            }else{
                return ResponseFormatter::error(null, 'Data Tidak Ada', 404);
            }
    }
}
