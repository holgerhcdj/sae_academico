<?php
namespace App\Http\Controllers;
use App\Http\Requests\CreateInsumosRequest;
use App\Http\Requests\UpdateInsumosRequest;
use App\Repositories\InsumosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\DB;
use Response;
use Session;
use App\Models\Auditoria;

class InsumosController extends AppBaseController
{
    /** @var  InsumosRepository */
    private $insumosRepository;
    private $anl;

    public function __construct(InsumosRepository $insumosRepo)
    {
        $this->insumosRepository = $insumosRepo;
        //$this->anl=Session::get('anl_id');
    }

    /**
     * Display a listing of the Insumos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->insumosRepository->pushCriteria(new RequestCriteria($request));
        //$insumos = $this->insumosRepository->all();
        $this->anl=Session::get('anl_id');
        
        $insumos = DB::select("SELECT * FROM insumos i JOIN aniolectivo a on i.anl_id=a.id WHERE i.anl_id=$this->anl order by i.id");

        return view('insumos.index')
            ->with('insumos', $insumos);
    }

    /**
     * Show the form for creating a new Insumos.
     *
     * @return Response
     */
    public function create()
    {
        return view('insumos.create');
    }

    /**
     * Store a newly created Insumos in storage.
     *
     * @param CreateInsumosRequest $request
     *
     * @return Response
     */
    public function store(CreateInsumosRequest $request)
    {
        $input = $request->all();
        $insumos = $this->insumosRepository->create($input);
                 $aud= new Auditoria();
                 $data=["mod"=>"Insumos","acc"=>"Insertar","dat"=>$insumos,"doc"=>"NA"];
                 $aud->save_adt($data);                    

        Flash::success('Insumo Guardado Correctamente.');
        return redirect(route('insumos.index'));
    }

    /**
     * Display the specified Insumos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $insumos = $this->insumosRepository->findWithoutFail($id);

        if (empty($insumos)) {
            Flash::error('Insumos not found');

            return redirect(route('insumos.index'));
        }

        return view('insumos.show')->with('insumos', $insumos);
    }

    /**
     * Show the form for editing the specified Insumos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $insumos = $this->insumosRepository->findWithoutFail($id);

        if (empty($insumos)) {
            Flash::error('Insumos not found');

            return redirect(route('insumos.index'));
        }

        return view('insumos.edit')->with('insumos', $insumos);
    }

    /**
     * Update the specified Insumos in storage.
     *
     * @param  int              $id
     * @param UpdateInsumosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInsumosRequest $request)
    {
        $insumos = $this->insumosRepository->findWithoutFail($id);

        if (empty($insumos)) {
            Flash::error('Insumos not found');

            return redirect(route('insumos.index'));
        }

        $insumos = $this->insumosRepository->update($request->all(), $id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Insumos","acc"=>"Modificar","dat"=>$insumos,"doc"=>"NA"];
                 $aud->save_adt($data);                    

        Flash::success('Insumo Editado Correctamente.');

        return redirect(route('insumos.index'));
    }

    /**
     * Remove the specified Insumos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $insumos = $this->insumosRepository->findWithoutFail($id);

        if (empty($insumos)) {
            Flash::error('Insumos not found');

            return redirect(route('insumos.index'));
        }

        $this->insumosRepository->delete($id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Insumos","acc"=>"Eliminar","dat"=>$insumos,"doc"=>"NA"];
                 $aud->save_adt($data);                    

        Flash::success('Insumo Eliminado Correctamente.');

        return redirect(route('insumos.index'));
    }
}
