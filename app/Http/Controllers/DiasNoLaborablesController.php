<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDiasNoLaborablesRequest;
use App\Http\Requests\UpdateDiasNoLaborablesRequest;
use App\Repositories\DiasNoLaborablesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DiasNoLaborablesController extends AppBaseController
{
    /** @var  DiasNoLaborablesRepository */
    private $diasNoLaborablesRepository;

    public function __construct(DiasNoLaborablesRepository $diasNoLaborablesRepo)
    {
        $this->diasNoLaborablesRepository = $diasNoLaborablesRepo;
    }

    /**
     * Display a listing of the DiasNoLaborables.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->diasNoLaborablesRepository->pushCriteria(new RequestCriteria($request));
        $diasNoLaborables = $this->diasNoLaborablesRepository->all();

        return view('dias_no_laborables.index')
            ->with('diasNoLaborables', $diasNoLaborables);
    }

    /**
     * Show the form for creating a new DiasNoLaborables.
     *
     * @return Response
     */
    public function create()
    {
        return view('dias_no_laborables.create');
    }

    /**
     * Store a newly created DiasNoLaborables in storage.
     *
     * @param CreateDiasNoLaborablesRequest $request
     *
     * @return Response
     */
    public function store(CreateDiasNoLaborablesRequest $request)
    {
        $input = $request->all();

        $diasNoLaborables = $this->diasNoLaborablesRepository->create($input);

        Flash::success('Dias No Laborables saved successfully.');

        return redirect(route('diasNoLaborables.index'));
    }

    /**
     * Display the specified DiasNoLaborables.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $diasNoLaborables = $this->diasNoLaborablesRepository->findWithoutFail($id);

        if (empty($diasNoLaborables)) {
            Flash::error('Dias No Laborables not found');

            return redirect(route('diasNoLaborables.index'));
        }

        return view('dias_no_laborables.show')->with('diasNoLaborables', $diasNoLaborables);
    }

    /**
     * Show the form for editing the specified DiasNoLaborables.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $diasNoLaborables = $this->diasNoLaborablesRepository->findWithoutFail($id);

        if (empty($diasNoLaborables)) {
            Flash::error('Dias No Laborables not found');

            return redirect(route('diasNoLaborables.index'));
        }

        return view('dias_no_laborables.edit')->with('diasNoLaborables', $diasNoLaborables);
    }

    /**
     * Update the specified DiasNoLaborables in storage.
     *
     * @param  int              $id
     * @param UpdateDiasNoLaborablesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDiasNoLaborablesRequest $request)
    {
        $diasNoLaborables = $this->diasNoLaborablesRepository->findWithoutFail($id);

        if (empty($diasNoLaborables)) {
            Flash::error('Dias No Laborables not found');

            return redirect(route('diasNoLaborables.index'));
        }

        $diasNoLaborables = $this->diasNoLaborablesRepository->update($request->all(), $id);

        Flash::success('Dias No Laborables updated successfully.');

        return redirect(route('diasNoLaborables.index'));
    }

    /**
     * Remove the specified DiasNoLaborables from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $diasNoLaborables = $this->diasNoLaborablesRepository->findWithoutFail($id);

        if (empty($diasNoLaborables)) {
            Flash::error('Dias No Laborables not found');

            return redirect(route('diasNoLaborables.index'));
        }

        $this->diasNoLaborablesRepository->delete($id);

        Flash::success('Dias No Laborables deleted successfully.');

        return redirect(route('diasNoLaborables.index'));
    }
}
