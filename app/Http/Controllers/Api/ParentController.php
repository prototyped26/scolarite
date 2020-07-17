<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\FamilleRepository;
use App\Repositories\ParentEleveRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ParentController extends Controller
{
    /**
     * @var ParentEleveRepository
     */
    private $parentEleveRepository;
    /**
     * @var FamilleRepository
     */
    private $familleRepository;

    /**
     * ParentEleveController constructor.
     * @param ParentEleveRepository $parentEleveRepository
     * @param FamilleRepository $familleRepository
     */
    public function __construct(
        ParentEleveRepository $parentEleveRepository, FamilleRepository $familleRepository
    )
    {
        $this->parentEleveRepository = $parentEleveRepository;
        $this->familleRepository = $familleRepository;
    }

    /**
     * Display a listing of ParentEleve.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->parentEleveRepository->getAll()->load(['familles',  'paiements']), Response::HTTP_OK);

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
            $list = [];

            foreach ($request->input('famille') as $id_eleve) {
                $list[] = [
                    'eleve_id' => $id_eleve,
                    'parent_eleve_id' => $parentEleve->id
                ];
            }

            foreach ($list as $data) {
                $res = $this->familleRepository->store($data);
                Log::info(json_encode($res));
            }
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
        $parentEleve = $this->parentEleveRepository->getById($id, ['familles', 'paiements']);
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

            // delete les familles
            $familles = $parentEleve->familles;

            foreach ($familles as $famille) {
                $this->familleRepository->forceDelete($famille->id);
            }

            $parentEleve = $this->parentEleveRepository->update($parentEleve->id, $request->all());
            if ($parentEleve) {
                $list = [];

                foreach ($request->input('famille') as $id_eleve) {
                    $list[] = [
                        'eleve_id' => $id_eleve,
                        'parent_id' => $parentEleve->id
                    ];
                }

                foreach ($list as $data) {
                    Log::info(json_encode($data));
                    $this->familleRepository->store($data);
                }

                return response()->json($parentEleve, Response::HTTP_OK);
            }


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
