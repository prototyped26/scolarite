<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CaracteristiqueRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CaracteristiqueController extends Controller
{
    /**
     * @var CaracteristiqueRepository
     */
    private $caracteristiqueRepository;

    /**
     * CaracteristiqueController constructor.
     * @param CaracteristiqueRepository $caracteristiqueRepository
     */
    public function __construct(
        CaracteristiqueRepository $caracteristiqueRepository
    )
    {
        $this->caracteristiqueRepository = $caracteristiqueRepository;
    }

    /**
     * Display a listing of Caracteristique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->caracteristiqueRepository->getAll(), Response::HTTP_OK);
    }

    public function list(Request $request, $frais)
    {
        return response()->json($this->caracteristiqueRepository->byFrais($frais), Response::HTTP_OK);
    }

    /**
     * Store a newly created Caracteristique in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $caracteristique = $this->caracteristiqueRepository->store($request->all());
        if ($caracteristique) {
            //todo process to model eager load
            return response()->json($caracteristique, Response::HTTP_OK);
        }
        return response()->json(['message' => __('message.errors.store')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified Caracteristique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $caracteristique = $this->caracteristiqueRepository->getById($id);
        if ($caracteristique) {
            return response()->json($caracteristique, Response::HTTP_OK);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.caracteristique')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified Caracteristique in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $caracteristique = $this->caracteristiqueRepository->getById($id);
        if ($caracteristique) {

            $caracteristique = $this->caracteristiqueRepository->update($caracteristique->id, $request->all());
            if ($caracteristique)
                return response()->json($caracteristique, Response::HTTP_OK);

            return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified Caracteristique from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $caracteristique = $this->caracteristiqueRepository->getById($id);
        if ($caracteristique) {
            if ($this->caracteristiqueRepository->destroy($caracteristique->id))
                return response()->json(['message' => __('message.success.destroyed')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.destroy')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.caracteristique')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Restore the specified Caracteristique from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $caracteristique = $this->caracteristiqueRepository->getById($id);
        if ($caracteristique) {
            if ($this->caracteristiqueRepository->restore($caracteristique->id))
                return response()->json(['message' => __('message.success.restored')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.restore')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.caracteristique')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Force delete the specified Caracteristique from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $caracteristique = $this->caracteristiqueRepository->getById($id);
        if ($caracteristique) {
            if ($this->caracteristiqueRepository->forceDelete($caracteristique->id))
                return response()->json(['message' => __('message.success.deleted')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.delete')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.caracteristique')])
        ], Response::HTTP_BAD_REQUEST);
    }
}
