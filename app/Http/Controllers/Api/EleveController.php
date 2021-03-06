<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AnneeRepository;
use App\Repositories\EleveRepository;
use App\Repositories\ParcourRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EleveController extends Controller
{
    /**
     * @var EleveRepository
     */
    private $eleveRepository;
    /**
     * @var ParcourController
     */
    private $parcourController;
    /**
     * @var AnneeRepository
     */
    private $anneeRepository;
    /**
     * @var ParcourRepository
     */
    private $parcourRepository;

    /**
     * EleveController constructor.
     * @param EleveRepository $eleveRepository
     * @param AnneeRepository $anneeRepository
     */
    public function __construct(
        EleveRepository $eleveRepository, ParcourRepository $parcourRepository, AnneeRepository $anneeRepository
    )
    {
        $this->eleveRepository = $eleveRepository;
        $this->anneeRepository = $anneeRepository;
        $this->parcourRepository = $parcourRepository;
    }

    /**
     * Display a listing of Eleve.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->eleveRepository->getAll()->load(['familles', 'parcours']), Response::HTTP_OK);

    }

    /**
     * Store a newly created Eleve in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $eleve = $this->eleveRepository->store($request->all());
        if ($eleve) {
            //todo process to model eager load

            $data = [
                'eleve_id' => $eleve->id,
                'classe_id' => $request->input('classe_id'),
                'annee_id' => $this->anneeRepository->active()->id,
                'redouble' => false,
            ];

            Log::info(json_encode($data));

            $res = $this->parcourRepository->store($data);

            return response()->json($res, Response::HTTP_OK);
        }
        return response()->json(['message' => __('message.errors.store')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified Eleve.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $eleve = $this->eleveRepository->getById($id, ['parcours']);
        if ($eleve) {
            return response()->json($eleve, Response::HTTP_OK);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.eleve')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified Eleve in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $eleve = $this->eleveRepository->getById($id, [], $request->user()->isSuperAdmin());
        if ($eleve) {
            $eleve = $this->eleveRepository->update($eleve->id, $request->all());
            if ($eleve)
                return response()->json($eleve, Response::HTTP_OK);

            return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified Eleve from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $eleve = $this->eleveRepository->getById($id);
        if ($eleve) {
            if ($this->eleveRepository->destroy($eleve->id))
                return response()->json(['message' => __('message.success.destroyed')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.destroy')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.eleve')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Restore the specified Eleve from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $eleve = $this->eleveRepository->getById($id, [], true);
        if ($eleve) {
            if ($this->eleveRepository->restore($eleve->id))
                return response()->json(['message' => __('message.success.restored')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.restore')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.eleve')])
        ], Response::HTTP_BAD_REQUEST);
    }

    public function eleveClasse(Request $request, $classe) {

        $annee = $this->anneeRepository->active();

        return \response()->json($this->eleveRepository->classe($classe, $annee));

    }

    /**
     * Force delete the specified Eleve from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $eleve = $this->eleveRepository->getById($id, [], true);
        if ($eleve) {
            if ($this->eleveRepository->forceDelete($eleve->id))
                return response()->json(['message' => __('message.success.deleted')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.delete')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.eleve')])
        ], Response::HTTP_BAD_REQUEST);
    }
}
