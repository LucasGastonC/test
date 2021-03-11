<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Deudor;
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

                $cui = substr($registro, 13, 11);
                $situacionPrestamo = substr($registro, 27, 2);
                $sumaPrestamos = substr($registro, 29, 12);
                $idInstitucion = substr($registro, 13, 11);
                $deudor = Deudor::where('cui', $cui)->first();
                if ($deudor) {
                    $deudor->sumaPrestamos = $deudor->sumaPrestamos + $sumaPrestamo;
                    if ($deudor->situacionPrestamo > $situacionPrestamo) {
                        $deudor->situacionPrestamo = $situacionPrestamo;
                    }
                }
                die();
                if ($cui) {
                    # code...
                }
                
                $deudor = new Deudor();
                $deudor->cui = substr($registro, 13, 11);
                $deudor->situacionPrestamo = 
                $deudor->sumaPrestamos =    
                $deudor->save();

    		}

            $deudores = Deudor::all();

            var_dump($deudores[0]);


    		die();

    	}

    	return redirect()->action([ParserController::class, 'index'])->with('status', 'Archivo cargado');
    }

    public function limpiar(){

    }
}
