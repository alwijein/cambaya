<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function allJadwalSiswa(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');

        $hari = $request->input('kode_hari');
        $kelas = $request->input('kelas');


        // dd($all);

        if($id){
            $jadwal = Jadwal::with(['pelajaran', 'guru'])->find($id);
            if($jadwal){
                return ResponseFormatter::success($jadwal, 'Data Berhasil Diambil');
            }else{
                return ResponseFormatter::error(null, 'Data Tidak Ada', 404);
            }
        }

        $jadwal = Jadwal::with(['pelajaran', 'guru'])->where('kode_kelas', $kelas);

        if ($hari){
            $jadwal->where('kode_hari', $hari);
        }

        return ResponseFormatter::success(
            $jadwal->paginate($limit),
            'Data berhasil diambil'
        );
    }

    public function allJadwalUjian(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');

        $hari = $request->input('kode_hari');


        // dd($all);

        if($id){
            $jadwal = Jadwal::with('pelajaran')->find($id);
            if($jadwal){
                return ResponseFormatter::success($jadwal, 'Data Berhasil Diambil');
            }else{
                return ResponseFormatter::error(null, 'Data Tidak Ada', 404);
            }
        }

        $jadwal = Jadwal::with('pelajaran');

        if ($hari){
            $jadwal->where('kode_hari', $hari);
        }

        return ResponseFormatter::success(
            $jadwal->paginate($limit),
            'Data berhasil diambil'
        );
    }
}
