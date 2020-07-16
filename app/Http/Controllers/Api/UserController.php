<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function currentUser(){
        return \response()->json(Auth::user(), Response::HTTP_OK);
    }

    /**
     * Display a listing of User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($this->userRepository->getAll($request), Response::HTTP_OK);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //todo enter validation rules
        ]);
        if ($validator->fails())
            return response()->json([
                'message' => __('message.errors.field'), 'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        else {
            $user = $this->userRepository->store($request->all());
            if ($user) {
                //todo process to model eager load
                return response()->json($user, Response::HTTP_OK);
            }
            return response()->json(['message' => __('message.errors.store')], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $relations = []; //todo specified model relation to eager load
        $user = $this->userRepository->getById($id);
        return response()->json($user, Response::HTTP_OK);

    }

    /**
     * Update the specified User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = $this->userRepository->getById($id);
        if ($user) {
            try {
                $this->authorize('update', $user);
                $validator = Validator::make($request->all(), [
                    //todo enter validation rules
                ]);
                if ($validator->fails())
                    return response()->json([
                        'message' => __('message.errors.field'), 'errors' => $validator->errors()
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                else {
                    $user = $this->userRepository->update($user->id, $request->all());
                    if ($user)
                        return response()->json($user, Response::HTTP_OK);

                    return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
                }
            } catch (AuthorizationException $e) {
                return response()->json(['message' => __('auth.forbidden')], Response::HTTP_FORBIDDEN);
            }
        }
        return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified User from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = $this->userRepository->getById($id);
        if ($user) {
            if ($this->userRepository->destroy($user->id))
                return response()->json(['message' => __('message.success.destroyed')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.destroy')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.user')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Restore the specified User from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $user = $this->userRepository->getById($id, [], true);
        if ($user) {
            if ($this->userRepository->restore($user->id))
                return response()->json(['message' => __('message.success.restored')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.restore')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.user')])
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Force delete the specified User from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $user = $this->userRepository->getById($id, [], true);
        if ($user) {
            if ($this->userRepository->forceDelete($user->id))
                return response()->json(['message' => __('message.success.deleted')], Response::HTTP_OK);
            else
                return response()->json(['message' => __('message.errors.delete')], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => __('message.errors.find', ['model' => trans('message.models.user')])
        ], Response::HTTP_BAD_REQUEST);
    }
}
