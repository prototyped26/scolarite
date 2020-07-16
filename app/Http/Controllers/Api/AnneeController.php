<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AnneeRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AnneeController extends Controller
{
    /**
     * @var AnneeRepository
     */
    private $anneeRepository;

    /**
     * AnneeController constructor.
     * @param AnneeRepository $anneeRepository
     */
    public function __construct(
        AnneeRepository $anneeRepository
    )
    {
        $this->anneeRepository = $anneeRepository;
    }

    /**
     * Display a listing of Annee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->anneeRepository->getAll(), Response::HTTP_OK);
    }

    /**
     * Store a newly created Annee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $annee = $this->anneeRepository->store($request->all());
        if ($annee) {
            //todo process to model eager load
            return response()->json($annee, Response::HTTP_OK);
        }
        return response()->json(['message' => __('message.errors.store')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified Annee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $annee = $this->anneeRepository->getById($id);
        if ($annee) {
            return response()->json($annee, Response::HTTP_OK);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.annee')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified Annee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $annee = $this->anneeRepository->getById($id);
        if ($annee) {
            $annee = $this->anneeRepository->update($annee->id, $request->all());
            if ($annee)
                return response()->json($annee, Response::HTTP_OK);

            return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified Annee from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $annee = $this->anneeRepository->getById($id);
        if ($annee) {
            if ($this->anneeRepository->destroy($annee->id))
                return response()->json(['message' => __('message.success.destroyed')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.destroy')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.annee')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Restore the specified Annee from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $annee = $this->anneeRepository->getById($id, [], true);
        if ($annee) {
            if ($this->anneeRepository->restore($annee->id))
                return response()->json(['message' => __('message.success.restored')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.restore')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.annee')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Force delete the specified Annee from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $annee = $this->anneeRepository->getById($id, [], true);
        if ($annee) {
            if ($this->anneeRepository->forceDelete($annee->id))
                return response()->json(['message' => __('message.success.deleted')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.delete')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.annee')])
        ], Response::HTTP_BAD_REQUEST);
    }
}
