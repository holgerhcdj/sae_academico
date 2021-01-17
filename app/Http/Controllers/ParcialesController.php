<?php
namespace App\Http\Controllers;
use App\Http\Requests\CreateParcialesRequest;
use App\Http\Requests\UpdateParcialesRequest;
use App\Repositories\ParcialesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Session;

class ParcialesController extends AppBaseController
{
    /** @var  ParcialesRepository */
    private $parcialesRepository;

    public function __construct(ParcialesRepository $parcialesRepo)
    {
        $this->parcialesRepository = $parcialesRepo;
    }

    /**
     * Display a listing of the Parciales.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->parcialesRepository->pushCriteria(new RequestCriteria($request));
        $parciales = $this->parcialesRepository
        ->findWhere(['anl_id'=>Session::get('anl_id')])
        ;
        return view('parciales.index')
            ->with('parciales', $parciales);
    }

    /**
     * Show the form for creating a new Parciales.
     *
     * @return Response
     */
    public function create()
    {
        return view('parciales.create');
    }

    /**
     * Store a newly created Parciales in storage.
     *
     * @param CreateParcialesRequest $request
     *
     * @return Response
     */
    public function store(CreateParcialesRequest $request)
    {
        $input = $request->all();
        try {
            $parciales = $this->parcialesRepository->create($input);
            Flash::success('Parciales saved successfully.');
            return redirect(route('parciales.index'));
        } catch (\App\Exceptions\NotFoundmonException $e) {

            return $e->getMessage();
            
        }
    }

    /**
     * Display the specified Parciales.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $parciales = $this->parcialesRepository->findWithoutFail($id);

        if (empty($parciales)) {
            Flash::error('Parciales not found');

            return redirect(route('parciales.index'));
        }

        return view('parciales.show')->with('parciales', $parciales);
    }

    /**
     * Show the form for editing the specified Parciales.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $parciales = $this->parcialesRepository->findWithoutFail($id);

        if (empty($parciales)) {
            Flash::error('Parciales not found');

            return redirect(route('parciales.index'));
        }

        return view('parciales.edit')->with('parciales', $parciales);
    }

    /**
     * Update the specified Parciales in storage.
     *
     * @param  int              $id
     * @param UpdateParcialesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateParcialesRequest $request)
    {

        
        
        $parciales = $this->parcialesRepository->findWithoutFail($id);
        if (empty($parciales)) {
            Flash::error('Parciales not found');
            return redirect(route('parciales.index'));
        }
        $parciales = $this->parcialesRepository->update($request->all(), $id);
        Flash::success('Parciales updated successfully.');
        return redirect(route('parciales.index'));
    }

    /**
     * Remove the specified Parciales from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $parciales = $this->parcialesRepository->findWithoutFail($id);

        if (empty($parciales)) {
            Flash::error('Parciales not found');

            return redirect(route('parciales.index'));
        }

        $this->parcialesRepository->delete($id);

        Flash::success('Parciales deleted successfully.');

        return redirect(route('parciales.index'));
    }
}
