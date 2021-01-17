<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEncGruposRequest;
use App\Http\Requests\UpdateEncGruposRequest;
use App\Repositories\EncGruposRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
class EncGruposController extends AppBaseController
{
    /** @var  EncGruposRepository */
    private $encGruposRepository;

    public function __construct(EncGruposRepository $encGruposRepo)
    {
        $this->encGruposRepository = $encGruposRepo;
    }

    /**
     * Display a listing of the EncGrupos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->encGruposRepository->pushCriteria(new RequestCriteria($request));
        $encGrupos = $this->encGruposRepository->all();

        return view('enc_grupos.index')
            ->with('encGrupos', $encGrupos);
    }

    /**
     * Show the form for creating a new EncGrupos.
     *
     * @return Response
     */
    public function create()
    {
        return view('enc_grupos.create');
    }

    /**
     * Store a newly created EncGrupos in storage.
     *
     * @param CreateEncGruposRequest $request
     *
     * @return Response
     */
    public function store(CreateEncGruposRequest $request)
    {
        $input = $request->all();

        $encGrupos = $this->encGruposRepository->create($input);

        Flash::success('Enc Grupos saved successfully.');

        return redirect(route('encGrupos.index'));
    }

    /**
     * Display the specified EncGrupos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
//        dd('ok');
        $rep=DB::select("SELECT re.usu_id,u.usu_apellidos,u.name,count(*)
            FROM enc_registro_encuestas re JOIN users u
            ON re.usu_id=u.id 
            GROUP BY re.usu_id,u.usu_apellidos,u.name
            ");
        //dd($rep);
         return view('enc_grupos.show')->with('rep', $rep);
    }

    /**
     * Show the form for editing the specified EncGrupos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $encGrupos = $this->encGruposRepository->findWithoutFail($id);

        if (empty($encGrupos)) {
            Flash::error('Enc Grupos not found');

            return redirect(route('encGrupos.index'));
        }

        return view('enc_grupos.edit')->with('encGrupos', $encGrupos);
    }

    /**
     * Update the specified EncGrupos in storage.
     *
     * @param  int              $id
     * @param UpdateEncGruposRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEncGruposRequest $request)
    {
        $encGrupos = $this->encGruposRepository->findWithoutFail($id);

        if (empty($encGrupos)) {
            Flash::error('Enc Grupos not found');

            return redirect(route('encGrupos.index'));
        }

        $encGrupos = $this->encGruposRepository->update($request->all(), $id);

        Flash::success('Enc Grupos updated successfully.');

        return redirect(route('encGrupos.index'));
    }

    /**
     * Remove the specified EncGrupos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $encGrupos = $this->encGruposRepository->findWithoutFail($id);

        if (empty($encGrupos)) {
            Flash::error('Enc Grupos not found');

            return redirect(route('encGrupos.index'));
        }

        $this->encGruposRepository->delete($id);

        Flash::success('Enc Grupos deleted successfully.');

        return redirect(route('encGrupos.index'));
    }
}
