<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PaiementRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PaiementController extends Controller
{
    /**
     * @var PaiementRepository
     */
    private $paiementRepository;

    /**
     * PaiementController constructor.
     * @param PaiementRepository $paiementRepository
     */
    public function __construct(
        PaiementRepository $paiementRepository
    )
    {
        $this->paiementRepository = $paiementRepository;
    }

    /**
     * Display a listing of Paiement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->paiementRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created Paiement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $paiement = $this->paiementRepository->store($request->all());
        if ($paiement) {
            //todo process to model eager load
            return response()->json($paiement, Response::HTTP_OK);
        }
        return response()->json(['message' => __('message.errors.store')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified Paiement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $paiement = $this->paiementRepository->getById($id);
        if ($paiement) {
            return response()->json($paiement, Response::HTTP_OK);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.paiement')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified Paiement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $paiement = $this->paiementRepository->getById($id);
        if ($paiement) {
            $paiement = $this->paiementRepository->update($paiement->id, $request->all());
            if ($paiement)
                return response()->json($paiement, Response::HTTP_OK);

            return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified Paiement from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $paiement = $this->paiementRepository->getById($id);
        if ($paiement) {
            if ($this->paiementRepository->destroy($paiement->id))
                return response()->json(['message' => __('message.success.destroyed')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.destroy')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.paiement')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Restore the specified Paiement from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $paiement = $this->paiementRepository->getById($id);
        if ($paiement) {
            if ($this->paiementRepository->restore($paiement->id))
                return response()->json(['message' => __('message.success.restored')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.restore')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.paiement')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Force delete the specified Paiement from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $paiement = $this->paiementRepository->getById($id, [], true);
        if ($paiement) {
            if ($this->paiementRepository->forceDelete($paiement->id))
                return response()->json(['message' => __('message.success.deleted')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.delete')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.paiement')])
        ], Response::HTTP_BAD_REQUEST);
    }
}
