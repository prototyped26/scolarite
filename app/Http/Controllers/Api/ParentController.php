<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ParentEleveRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ParentController extends Controller
{
    /**
     * @var ParentEleveRepository
     */
    private $parentEleveRepository;

    /**
     * ParentEleveController constructor.
     * @param ParentEleveRepository $parentEleveRepository
     */
    public function __construct(
        ParentEleveRepository $parentEleveRepository
    )
    {
        $this->parentEleveRepository = $parentEleveRepository;
    }

    /**
     * Display a listing of ParentEleve.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->parentEleveRepository->index($request), Response::HTTP_OK);

    }

    /**
     * Store a newly created ParentEleve in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $parentEleve = $this->parentEleveRepository->store($request->all());
        if ($parentEleve) {
            //todo process to model eager load
            return response()->json($parentEleve, Response::HTTP_OK);
        }
        return response()->json(['message' => __('message.errors.store')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified ParentEleve.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $parentEleve = $this->parentEleveRepository->getById($id);
        if ($parentEleve) {
            return response()->json($parentEleve, Response::HTTP_OK);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.parentEleve')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified ParentEleve in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $parentEleve = $this->parentEleveRepository->getById($id);
        if ($parentEleve) {
            $parentEleve = $this->parentEleveRepository->update($parentEleve->id, $request->all());
            if ($parentEleve)
                return response()->json($parentEleve, Response::HTTP_OK);

            return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified ParentEleve from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $parentEleve = $this->parentEleveRepository->getById($id);
        if ($parentEleve) {

            if ($this->parentEleveRepository->destroy($parentEleve->id))
                return response()->json(['message' => __('message.success.destroyed')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.destroy')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.parentEleve')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Restore the specified ParentEleve from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $parentEleve = $this->parentEleveRepository->getById($id, [], true);
        if ($parentEleve) {
            if ($this->parentEleveRepository->restore($parentEleve->id))
                return response()->json(['message' => __('message.success.restored')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.restore')], Response::HTTP_BAD_REQUEST);
            try {
                $this->authorize('restore', $parentEleve);
            } catch (AuthorizationException $e) {
                return response()->json(['message' => __('auth.forbidden')], Response::HTTP_FORBIDDEN);
            }
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.parentEleve')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Force delete the specified ParentEleve from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $parentEleve = $this->parentEleveRepository->getById($id, [], true);
        if ($parentEleve) {

            if ($this->parentEleveRepository->forceDelete($parentEleve->id))
                return response()->json(['message' => __('message.success.deleted')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.delete')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.parentEleve')])
        ], Response::HTTP_BAD_REQUEST);
    }
}
