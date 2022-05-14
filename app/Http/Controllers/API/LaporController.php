<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\AbsensiSiswa;
use App\Models\Nilai;
use App\Models\NilaiEkstrakurikuler;
use App\Models\NilaiPrestasi;
use App\Models\NilaiSikap;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporController extends Controller
{
    public function all(Request $request)
    {
        $semester = $request->input('semester');


        // dd($all);
            $siswa = Siswa::where('no_induk', Auth::user()->email)->first();

            $sakit = AbsensiSiswa::where('kode_siswa', $siswa->id)->where('kode_kehadiran', 4)->count();

            $izin = AbsensiSiswa::where('kode_siswa', $siswa->id)->where('kode_kehadiran', 2)->count();

            $bertugasKeluar = AbsensiSiswa::where('kode_siswa', $siswa->id)->where('kode_kehadiran', 3)->count();

            $terlambat = AbsensiSiswa::where('kode_siswa', $siswa->id)->where('kode_kehadiran', 5)->count();

            $tanpaKeterangan = AbsensiSiswa::where('kode_siswa', $siswa->id)->where('kode_kehadiran', 6)->count();


            // ...

            $pengetahuan = Nilai::with(['pelajaran'])->where('kode_siswa', $siswa->id)->where('semester', $semester)->get();

            $sikap = NilaiSikap::where('kode_siswa', $siswa->id)->where('semester', $semester)->get();

            $ekstrakurikuler = NilaiEkstrakurikuler::where('kode_siswa', $siswa->id)->where('semester', $semester)->get();

            $prestasi = NilaiPrestasi::where('kode_siswa', $siswa->id)->where('semester', $semester)->get();

            $absen = array("sakit" => $sakit, "izin" => $izin, "bertugasKeluar" => $bertugasKeluar, "terlambat" => $terlambat, "tanpaKeterangan" => $tanpaKeterangan);


                return ResponseFormatter::success([
                    "pengetahuan" => $pengetahuan,
                    "sikap" => $sikap,
                    "ekstrakurikuler" => $ekstrakurikuler,
                    "prestasi" => $prestasi,
                        "absen" => $absen,
                ], 'Data Berhasil Diambil');

                // return ResponseFormatter::error(null, 'Data Tidak Ada', 404);

    }
}
