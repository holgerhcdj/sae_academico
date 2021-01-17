<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlantillasSmsRequest;
use App\Http\Requests\UpdatePlantillasSmsRequest;
use App\Repositories\PlantillasSmsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class PlantillasSmsController extends AppBaseController
{
    /** @var  PlantillasSmsRepository */
    private $plantillasSmsRepository;

    public function __construct(PlantillasSmsRepository $plantillasSmsRepo)
    {
        $this->plantillasSmsRepository = $plantillasSmsRepo;
    }

    /**
     * Display a listing of the PlantillasSms.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->plantillasSmsRepository->pushCriteria(new RequestCriteria($request));
        $plantillasSms = $this->plantillasSmsRepository->all();

        return view('plantillas_sms.index')
            ->with('plantillasSms', $plantillasSms);
    }

    /**
     * Show the form for creating a new PlantillasSms.
     *
     * @return Response
     */
    public function create()
    {
        return view('plantillas_sms.create');
    }

    /**
     * Store a newly created PlantillasSms in storage.
     *
     * @param CreatePlantillasSmsRequest $request
     *
     * @return Response
     */
    public function store(CreatePlantillasSmsRequest $request)
    {
        $input = $request->all();

        $plantillasSms = $this->plantillasSmsRepository->create($input);

        Flash::success('Plantillas Sms saved successfully.');

        return redirect(route('plantillasSms.index'));
    }

    /**
     * Display the specified PlantillasSms.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $plantillasSms = $this->plantillasSmsRepository->findWithoutFail($id);

        if (empty($plantillasSms)) {
            Flash::error('Plantillas Sms not found');

            return redirect(route('plantillasSms.index'));
        }

        return view('plantillas_sms.show')->with('plantillasSms', $plantillasSms);
    }

    /**
     * Show the form for editing the specified PlantillasSms.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $plantillasSms = $this->plantillasSmsRepository->findWithoutFail($id);

        if (empty($plantillasSms)) {
            Flash::error('Plantillas Sms not found');

            return redirect(route('plantillasSms.index'));
        }

        return view('plantillas_sms.edit')->with('plantillasSms', $plantillasSms);
    }

    /**
     * Update the specified PlantillasSms in storage.
     *
     * @param  int              $id
     * @param UpdatePlantillasSmsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePlantillasSmsRequest $request)
    {
        $plantillasSms = $this->plantillasSmsRepository->findWithoutFail($id);

        if (empty($plantillasSms)) {
            Flash::error('Plantillas Sms not found');

            return redirect(route('plantillasSms.index'));
        }

        $plantillasSms = $this->plantillasSmsRepository->update($request->all(), $id);

        Flash::success('Plantillas Sms updated successfully.');

        return redirect(route('plantillasSms.index'));
    }

    public function busca_una_plantilla(Request $req){
        $dt=$req->all();
        $plant=DB::select("SELECT * FROM plantillas_sms WHERE pln_id=$dt[pln_id]");
        return response()->json($plant);
    }
    public function busca_plantillas(Request $req){
        $plant=DB::select("SELECT * FROM plantillas_sms ORDER BY pln_descripcion");
        $rst="<table class='table'><tr><th colspan='2' class='bg-green text-center'>PLANTILLAS APROBADOS PARA SMS
        <span data-dismiss='modal' class='close'  aria-label='Close' aria-hidden='true'>&times;</span>
        </th></tr><tr><th>Seleccionar</th><th>Plantilla</th></tr>";
        foreach ($plant as $p) {
            $rst.="<tr>
                    <td><i class='fa fa-check btn btn-primary btn-xs btn_select' data='$p->pln_id' ></i></td>
                    <td>$p->pln_descripcion</td>
                   </tr>";
        }
        $rst.="</table>";
        return response()->json($rst);

    }

    public function destroy($id)
    {
        $plantillasSms = $this->plantillasSmsRepository->findWithoutFail($id);

        if (empty($plantillasSms)) {
            Flash::error('Plantillas Sms not found');

            return redirect(route('plantillasSms.index'));
        }

        $this->plantillasSmsRepository->delete($id);

        Flash::success('Plantillas Sms deleted successfully.');

        return redirect(route('plantillasSms.index'));
    }
}
