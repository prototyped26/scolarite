<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\EleveRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EleveController extends Controller
{
    /**
     * @var EleveRepository
     */
    private $eleveRepository;

    /**
     * EleveController constructor.
     * @param EleveRepository $eleveRepository
     */
    public function __construct(
        EleveRepository $eleveRepository
    )
    {
        $this->eleveRepository = $eleveRepository;
    }

    /**
     * Display a listing of Eleve.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->eleveRepository->index($request), Response::HTTP_OK);

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
            return response()->json($eleve, Response::HTTP_OK);
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
        $eleve = $this->eleveRepository->getById($id);
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
