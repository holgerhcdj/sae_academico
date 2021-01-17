<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEncEncabezadoRequest;
use App\Http\Requests\UpdateEncEncabezadoRequest;
use App\Repositories\EncEncabezadoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\EncGrupos;
use DB;

class EncEncabezadoController extends AppBaseController
{
    /** @var  EncEncabezadoRepository */
    private $encEncabezadoRepository;

    public function __construct(EncEncabezadoRepository $encEncabezadoRepo)
    {
        $this->encEncabezadoRepository = $encEncabezadoRepo;
    }

    /**
     * Display a listing of the EncEncabezado.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        
        $this->encEncabezadoRepository->pushCriteria(new RequestCriteria($request));
        $encEncabezados = $this->encEncabezadoRepository->all();

        return view('enc_encabezados.index')
            ->with('encEncabezados', $encEncabezados);
    }

    /**
     * Show the form for creating a new EncEncabezado.
     *
     * @return Response
     */
    public function create()
    {
        return view('enc_encabezados.create');
    }

    /**
     * Store a newly created EncEncabezado in storage.
     *
     * @param CreateEncEncabezadoRequest $request
     *
     * @return Response
     */
    public function store(CreateEncEncabezadoRequest $request)
    {
        $input = $request->all();

        $encEncabezado = $this->encEncabezadoRepository->create($input);

        Flash::success('Enc Encabezado saved successfully.');

        return redirect(route('encEncabezados.index'));
    }

    /**
     * Display the specified EncEncabezado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function eliminar_preguntas(Request $req){
        $dat=$req->all();
        //dd($dat);
        DB::select("delete from  enc_preguntas where prg_id=".$dat['prg_id']);

        return redirect(route('encEncabezados.show',$dat['enc_id']));

    }
    public function grabar_preguntas(Request $req){

        $dat=$req->all();
        //dd($dat);
        DB::select("insert into enc_preguntas (
            enc_id,
            prg_pregunta, 
            prg_valoracion, 
            prg_estado, 
            grp_id)
            values
            (
            '$dat[enc_id]',
            '$dat[prg_pregunta]',
            0,
            0,
            '$dat[grp_id]'
        ) ");

        return redirect(route('encEncabezados.show',$dat['enc_id']));

    }

    public function show($id)
    {
        //dd($id);
        $grupos=EncGrupos::pluck('grp_descripcion','grp_id');
        $encEncabezado = $this->encEncabezadoRepository->findWithoutFail($id);
        $preg=DB::select("select * from enc_preguntas p
            join enc_grupos g on p.grp_id=g.grp_id
            where p.enc_id=$id");
        return view('enc_encabezados.show')
        ->with('encEncabezado', $encEncabezado)
        ->with('grupos', $grupos)
        ->with('preg', $preg)
        ;
    }



    /**
     * Show the form for editing the specified EncEncabezado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $encEncabezado = $this->encEncabezadoRepository->findWithoutFail($id);

        if (empty($encEncabezado)) {
            Flash::error('Enc Encabezado not found');

            return redirect(route('encEncabezados.index'));
        }

        return view('enc_encabezados.edit')->with('encEncabezado', $encEncabezado);
    }

    /**
     * Update the specified EncEncabezado in storage.
     *
     * @param  int              $id
     * @param UpdateEncEncabezadoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEncEncabezadoRequest $request)
    {
        $encEncabezado = $this->encEncabezadoRepository->findWithoutFail($id);

        if (empty($encEncabezado)) {
            Flash::error('Enc Encabezado not found');

            return redirect(route('encEncabezados.index'));
        }

        $encEncabezado = $this->encEncabezadoRepository->update($request->all(), $id);

        Flash::success('Enc Encabezado updated successfully.');

        return redirect(route('encEncabezados.index'));
    }

    /**
     * Remove the specified EncEncabezado from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $encEncabezado = $this->encEncabezadoRepository->findWithoutFail($id);

        if (empty($encEncabezado)) {
            Flash::error('Enc Encabezado not found');

            return redirect(route('encEncabezados.index'));
        }

        $this->encEncabezadoRepository->delete($id);

        Flash::success('Enc Encabezado deleted successfully.');

        return redirect(route('encEncabezados.index'));
    }
}
