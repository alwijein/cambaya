<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function all(Request $request)
    {
        // dd($all);

        try {

            $kelas = Kelas::all();

            return ResponseFormatter::success(
                $kelas,
                'Data berhasil diambil'
            );

        } catch (\Exception $e) {
            return ResponseFormatter::error('error',500);
        }

    }
}
