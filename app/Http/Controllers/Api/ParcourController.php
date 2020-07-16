<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ParcourRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ParcourController extends Controller
{
    /**
     * @var ParcourRepository
     */
    private $parcourRepository;

    /**
     * ParcourController constructor.
     * @param ParcourRepository $parcourRepository
     */
    public function __construct(
        ParcourRepository $parcourRepository
    )
    {
        $this->parcourRepository = $parcourRepository;
    }

    /**
     * Display a listing of Parcour.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->parcourRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created Parcour in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $parcour = $this->parcourRepository->store($request->all());
        if ($parcour) {
            //todo process to model eager load
            return response()->json($parcour, Response::HTTP_OK);
        }
        return response()->json(['message' => __('message.errors.store')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified Parcour.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $parcour = $this->parcourRepository->getById($id);
        if ($parcour) {
            return response()->json($parcour, Response::HTTP_OK);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.parcour')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified Parcour in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $parcour = $this->parcourRepository->getById($id);
        if ($parcour) {
            $parcour = $this->parcourRepository->update($parcour->id, $request->all());
            if ($parcour)
                return response()->json($parcour, Response::HTTP_OK);

            return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified Parcour from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $parcour = $this->parcourRepository->getById($id);
        if ($parcour) {
            if ($this->parcourRepository->destroy($parcour->id))
                return response()->json(['message' => __('message.success.destroyed')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.destroy')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.parcour')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Restore the specified Parcour from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $parcour = $this->parcourRepository->getById($id, [], true);
        if ($parcour) {
            if ($this->parcourRepository->restore($parcour->id))
                return response()->json(['message' => __('message.success.restored')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.restore')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.parcour')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Force delete the specified Parcour from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $parcour = $this->parcourRepository->getById($id, [], true);
        if ($parcour) {
            if ($this->parcourRepository->forceDelete($parcour->id))
                return response()->json(['message' => __('message.success.deleted')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.delete')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.parcour')])
        ], Response::HTTP_BAD_REQUEST);
    }
}
