<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Agenda;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agenda = Agenda::all();
        return $agenda;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nombre_materia' => ['required'],
            'docente' => ['required'],
            'tipo_materia' => ['required'],
        ],[
            'nombre_materia.required' => 'El valor del campo Materia es obligatorio.',
            'docente.required' => 'El valor del campo Docente es obligatorio.',
            'tipo_materia.required' => 'El valor del campo Tipo es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'message' => $validator->errors()->first(),
            ], 403);
        }

        $agenda = new Agenda;
        $agenda->nombre_materia = $request->input('nombre_materia');
        $agenda->docente = $request->input('docente');
        $agenda->tipo_materia = $request->input('tipo_materia');
        $agenda->save();

        return response()->json([
            'status' => 202,
            'message' => 'Registro exitoso',
        ], 202);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agenda = Agenda::where('id_agenda', $id)->get();
        return $agenda;
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
        $agenda = Agenda::where('id_agenda', $id)->first();
        $agenda->nombre_materia = $request->input('nombre_materia');
        $agenda->docente = $request->input('docente');
        $agenda->tipo_materia = $request->input('tipo_materia');
        $agenda->save();

        return response()->json([
            'status' => 202,
            'message' => 'Registro actualizado',
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agenda = Agenda::where('id_agenda', $id)->delete();
        return response()->json([
            'status' => 202,
            'message' => 'Registro Eliminado',
        ], 202);
    }
}
