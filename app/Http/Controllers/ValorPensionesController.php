<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateValorPensionesRequest;
use App\Http\Requests\UpdateValorPensionesRequest;
use App\Repositories\ValorPensionesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\AnioLectivo;
use App\Models\ValorPensiones;
use Illuminate\Support\Facades\Auth;
use App\Models\Jornadas;
use Illuminate\Support\Facades\DB;
use App\Models\Auditoria;

class ValorPensionesController extends AppBaseController
{
    /** @var  ValorPensionesRepository */
    private $valorPensionesRepository;

    public function __construct(ValorPensionesRepository $valorPensionesRepo)
    {
        $this->valorPensionesRepository = $valorPensionesRepo;
    }

    /**
     * Display a listing of the ValorPensiones.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $anl_select = AnioLectivo::where('anl_selected', '=', 1)->get();
        $anl=$anl_select[0];
        $valorPensiones=DB::select("select * from valor_pensiones vp join jornadas j on vp.jor_id=j.id ");
        return view('valor_pensiones.index')
            ->with('valorPensiones', $valorPensiones);
    }

    /**
     * Show the form for creating a new ValorPensiones.
     *
     * @return Response
     */
    public function create()
    {
        $jornadas=Jornadas::orderBy("jor_descripcion","ASC")->pluck("jor_descripcion","id");
        return view('valor_pensiones.create')->with('jornadas',$jornadas);
    }

    /**
     * Store a newly created ValorPensiones in storage.
     *
     * @param CreateValorPensionesRequest $request
     *
     * @return Response
     */
    public function store(CreateValorPensionesRequest $request)
    {
        $anl_select = AnioLectivo::where('anl_selected', '=', 1)->get();
        $usu = Auth::user();
        $anl=$anl_select[0];
        $input = $request->all();
        $input['anl_id']=$anl['id'];
        $input['responsable']=$usu->name;
        $valorPensiones = $this->valorPensionesRepository->create($input);
                            $datos = implode("-", array_flatten($valorPensiones['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"ValorPenciones","acc"=>"insertar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Valor Pensiones saved successfully.');

        return redirect(route('valorPensiones.index'));
    }

    /**
     * Display the specified ValorPensiones.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $valorPensiones = $this->valorPensionesRepository->findWithoutFail($id);

        if (empty($valorPensiones)) {
            Flash::error('Valor Pensiones not found');

            return redirect(route('valorPensiones.index'));
        }

        return view('valor_pensiones.show')->with('valorPensiones', $valorPensiones);
    }

    /**
     * Show the form for editing the specified ValorPensiones.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jornadas=Jornadas::orderBy("jor_descripcion","ASC")->pluck("jor_descripcion","id");
        
        $valorPensiones = $this->valorPensionesRepository->findWithoutFail($id);
        if (empty($valorPensiones)) {
            Flash::error('Valor Pensiones not found');

            return redirect(route('valorPensiones.index'));
        }

        return view('valor_pensiones.edit')->with('valorPensiones', $valorPensiones)->with('jornadas',$jornadas);
    }

    /**
     * Update the specified ValorPensiones in storage.
     *
     * @param  int              $id
     * @param UpdateValorPensionesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateValorPensionesRequest $request)
    {
        $input=$request->all();
        $usu = Auth::user();
        $input['responsable']=$usu->name;
        $valorPensiones = $this->valorPensionesRepository->findWithoutFail($id);

        if (empty($valorPensiones)) {
            Flash::error('Valor Pensiones not found');

            return redirect(route('valorPensiones.index'));
        }

        $valorPensiones = $this->valorPensionesRepository->update($input, $id);
                            $datos = implode("-", array_flatten($valorPensiones['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"ValorPenciones","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Valor Pensiones updated successfully.');

        return redirect(route('valorPensiones.index'));
    }

    /**
     * Remove the specified ValorPensiones from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $valorPensiones = $this->valorPensionesRepository->findWithoutFail($id);

        if (empty($valorPensiones)) {
            Flash::error('Valor Pensiones not found');

            return redirect(route('valorPensiones.index'));
        }

        $this->valorPensionesRepository->delete($id);
                            $datos = implode("-", array_flatten($valorPensiones['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"ValorPenciones","acc"=>"Eliminar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Valor Pensiones deleted successfully.');

        return redirect(route('valorPensiones.index'));
    }
}
