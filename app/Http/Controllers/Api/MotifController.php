<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\MotifRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MotifController extends Controller
{
    /**
     * @var MotifRepository
     */
    private $motifRepository;

    /**
     * MotifController constructor.
     * @param MotifRepository $motifRepository
     */
    public function __construct(
        MotifRepository $motifRepository
    )
    {
        $this->motifRepository = $motifRepository;
    }

    /**
     * Display a listing of Motif.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->motifRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created Motif in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $motif = $this->motifRepository->store($request->all());
        if ($motif) {
            //todo process to model eager load
            return response()->json($motif, Response::HTTP_OK);
        }
        return response()->json(['message' => __('message.errors.store')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified Motif.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $motif = $this->motifRepository->getById($id);
        if ($motif) {
            return response()->json($motif, Response::HTTP_OK);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.motif')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified Motif in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $motif = $this->motifRepository->getById($id);
        if ($motif) {
            $motif = $this->motifRepository->update($motif->id, $request->all());
            if ($motif)
                return response()->json($motif, Response::HTTP_OK);

            return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified Motif from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $motif = $this->motifRepository->getById($id);
        if ($motif) {
            if ($this->motifRepository->destroy($motif->id))
                return response()->json(['message' => __('message.success.destroyed')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.destroy')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.motif')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Restore the specified Motif from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $motif = $this->motifRepository->getById($id);
        if ($motif) {
            if ($this->motifRepository->restore($motif->id))
                return response()->json(['message' => __('message.success.restored')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.restore')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.motif')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Force delete the specified Motif from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $motif = $this->motifRepository->getById($id);
        if ($motif) {

            if ($this->motifRepository->forceDelete($motif->id))
                return response()->json(['message' => __('message.success.deleted')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.delete')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.motif')])
        ], Response::HTTP_BAD_REQUEST);
    }
}
