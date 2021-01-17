<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAvancesRequest;
use App\Http\Requests\UpdateAvancesRequest;
use App\Repositories\AvancesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AvancesController extends AppBaseController
{
    /** @var  AvancesRepository */
    private $avancesRepository;

    public function __construct(AvancesRepository $avancesRepo)
    {
        $this->avancesRepository = $avancesRepo;
    }

    /**
     * Display a listing of the Avances.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data=$request->all();
        if(!isset($data['btn_search'])){
            $data['estado']=0;
        }
//dd($data['estado']);
        $avances = DB::select("select * from avances where estado='".$data['estado']."' order by estado,responsable");

        return view('avances.index')
            ->with('avances', $avances);
    }

    /**
     * Show the form for creating a new Avances.
     *
     * @return Response
     */
    public function create()
    {
        return view('avances.create');
    }

    /**
     * Store a newly created Avances in storage.
     *
     * @param CreateAvancesRequest $request
     *
     * @return Response
     */
    public function store(CreateAvancesRequest $request)
    {
        $input = $request->all();
        $avances = $this->avancesRepository->create($input);
        Flash::success('Avances saved successfully.');
        return redirect(route('avances.index'));
    }

    /**
     * Display the specified Avances.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            Flash::error('Avances not found');

            return redirect(route('avances.index'));
        }

        return view('avances.show')->with('avances', $avances);
    }

    /**
     * Show the form for editing the specified Avances.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $avances = $this->avancesRepository->findWithoutFail($id);
           return view('avances.edit')->with('avances', $avances);
    }

    /**
     * Update the specified Avances in storage.
     *
     * @param  int              $id
     * @param UpdateAvancesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAvancesRequest $request)
    {
            $inp['f_fin']=date("Y-m-d");
            $inp['estado']=$request->all()['estado'];
            $avances = $this->avancesRepository->update($inp,$id);

        Flash::success('Avances updated successfully.');

        return redirect(route('avances.index'));
    }

    /**
     * Remove the specified Avances from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            Flash::error('Avances not found');

            return redirect(route('avances.index'));
        }

        $this->avancesRepository->delete($id);

        Flash::success('Avances deleted successfully.');

        return redirect(route('avances.index'));
    }
}
