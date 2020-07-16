<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ClasseRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ClasseController extends Controller
{
    /**
     * @var ClasseRepository
     */
    private $classeRepository;

    /**
     * ClasseController constructor.
     * @param ClasseRepository $classeRepository
     */
    public function __construct(
        ClasseRepository $classeRepository
    )
    {
        $this->classeRepository = $classeRepository;
    }

    /**
     * Display a listing of Classe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->classeRepository->getAll(), Response::HTTP_OK);
    }

    /**
     * Store a newly created Classe in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $classe = $this->classeRepository->store($request->all());
        if ($classe) {
            //todo process to model eager load
            return response()->json($classe, Response::HTTP_OK);
        }
        return response()->json(['message' => __('message.errors.store')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified Classe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $relations = []; //todo specified model relation to eager load
        $classe = $this->classeRepository->getById($id);
        if ($classe) {
            return response()->json($classe, Response::HTTP_OK);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.classe')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified Classe in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $classe = $this->classeRepository->getById($id, [], $request->user()->isSuperAdmin());
        if ($classe) {
            $classe = $this->classeRepository->update($classe->id, $request->all());
            if ($classe)
                return response()->json($classe, Response::HTTP_OK);

            return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified Classe from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $classe = $this->classeRepository->getById($id);
        if ($classe) {
            if ($this->classeRepository->destroy($classe->id))
                return response()->json(['message' => __('message.success.destroyed')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.destroy')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.classe')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Restore the specified Classe from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $classe = $this->classeRepository->getById($id, [], true);
        if ($classe) {
            try {
                $this->authorize('restore', $classe);
                if ($this->classeRepository->restore($classe->id))
                    return response()->json(['message' => __('message.success.restored')], Response::HTTP_OK);
                else
                    return response()->json(['message' => __('message.errors.restore')], Response::HTTP_BAD_REQUEST);
            } catch (AuthorizationException $e) {
                return response()->json(['message' => __('auth.forbidden')], Response::HTTP_FORBIDDEN);
            }
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.classe')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Force delete the specified Classe from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $classe = $this->classeRepository->getById($id, [], true);
        if ($classe) {
            if ($this->classeRepository->forceDelete($classe->id))
                return response()->json(['message' => __('message.success.deleted')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.delete')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.classe')])
        ], Response::HTTP_BAD_REQUEST);
    }
}
