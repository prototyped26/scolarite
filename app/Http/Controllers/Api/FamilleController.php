<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\FamilleRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FamilleController extends Controller
{
    /**
     * @var FamilleRepository
     */
    private $familleRepository;

    /**
     * FamilleController constructor.
     * @param FamilleRepository $familleRepository
     */
    public function __construct(
        FamilleRepository $familleRepository
    )
    {
        $this->familleRepository = $familleRepository;
    }

    /**
     * Display a listing of Famille.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->familleRepository->index($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created Famille in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $famille = $this->familleRepository->store($request->all());
        if ($famille) {
            //todo process to model eager load
            return response()->json($famille, Response::HTTP_OK);
        }
        return response()->json(['message' => __('message.errors.store')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified Famille.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $relations = []; //todo specified model relation to eager load
        $famille = $this->familleRepository->getById($id);
        if ($famille) {
            return response()->json($famille, Response::HTTP_OK);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.famille')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified Famille in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $famille = $this->familleRepository->getById($id);
        if ($famille) {
            $famille = $this->familleRepository->update($famille->id, $request->all());
            if ($famille)
                return response()->json($famille, Response::HTTP_OK);

            return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified Famille from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $famille = $this->familleRepository->getById($id);
        if ($famille) {
            if ($this->familleRepository->destroy($famille->id))
                return response()->json(['message' => __('message.success.destroyed')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.destroy')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.famille')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Restore the specified Famille from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $famille = $this->familleRepository->getById($id);
        if ($famille) {
            if ($this->familleRepository->restore($famille->id))
                return response()->json(['message' => __('message.success.restored')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.restore')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.famille')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Force delete the specified Famille from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $famille = $this->familleRepository->getById($id);
        if ($famille) {
            if ($this->familleRepository->forceDelete($famille->id))
                return response()->json(['message' => __('message.success.deleted')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.delete')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.famille')])
        ], Response::HTTP_BAD_REQUEST);
    }
}
