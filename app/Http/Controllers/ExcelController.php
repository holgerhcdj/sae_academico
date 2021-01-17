<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Laracasts\Flash\Flash;
use App\Models\AnioLectivo;
use App\Models\Cursos;
use App\Models\Jornadas;
use App\Models\Especialidades;
use App\Models\Sucursales;
use App\Models\Matriculas;
use PDF;
use App\Models\Auditoria;


class ExcelController extends Controller {

    public function index() {
        
        $cursos= Cursos::all();
        $pdf= PDF::loadView('pdf',['cursos' => $cursos]);
        return $pdf->stream();
        
    }

    //
}
