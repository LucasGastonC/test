<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Deudor;
use App\Models\Institucion;
// use Illuminate\Support\Facades\Storage;
class ParserController extends Controller
{
    public function index(){
    	return view('parser');
    }

    public function parse(Request $request){

		$validate = $this->validate($request,[
			'file' => 'required'
		]);

    	$file = $request->file('file');


    	if ($file) {
    		$registros = explode("\n", File::get($file));
    		foreach ($registros as $registro) {

                $cui = intval(substr($registro, 13, 11));
                $situacionPrestamo = intval(substr($registro, 27, 2));
                $sumaPrestamos = floatval(substr($registro, 29, 12));
                $idInstitucion = intval(substr($registro, 0, 5));

                $deudor = Deudor::where('cui', $cui)
                            ->where('idInstitucion', $idInstitucion)
                            ->get()
                            ->first();
                $institucion = Institucion::where('codigo', $idInstitucion)->first();
                
                /*Deudor*/

                if ($deudor) {
                    $deudor->sumaPrestamos = $deudor->sumaPrestamos + $sumaPrestamos;
                    if ($deudor->situacionPrestamo > $situacionPrestamo) {
                        $deudor->situacionPrestamo = $situacionPrestamo;
                    }
                }else{
                    $deudor = new Deudor();
                    $deudor->cui = $cui;
                    $deudor->situacionPrestamo = $situacionPrestamo;
                    $deudor->sumaPrestamos = $sumaPrestamos;
                    $deudor->idInstitucion = $idInstitucion;
                }
                /*Institucion*/
                $institucion = Institucion::where('codigo', $idInstitucion)->first();
                if ($institucion) {
                    $institucion->sumaPrestamos = $institucion->sumaPrestamos + $sumaPrestamos;
                }else{
                    $institucion = new Institucion();
                    $institucion->codigo = $idInstitucion;
                    $institucion->sumaPrestamos = $sumaPrestamos;
                }
                
                $institucion->save();
                $deudor->save();

    		}

    	}

    	return redirect()->action([ParserController::class, 'index'])->with('status', 'Archivo cargado correctamente');
    }

}
