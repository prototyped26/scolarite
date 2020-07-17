<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        return \response()->json(Auth::user()->load('role'), Response::HTTP_OK);
    }

    /**
     * Display a listing of User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->userRepository->getAll()->load('role'), Response::HTTP_OK);
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
            'nom' => 'required', 'login' => 'required', 'password' => 'required'
        ]);
        if ($validator->fails())
            return response()->json([
                'message' => __('message.errors.field'), 'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        else {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $user = $this->userRepository->store($data);
            if ($user) {
                //todo process to model eager load
                return response()->json($user, Response::HTTP_OK);
            }
            return response()->json(['message' => __('message.errors.store')], Response::HTTP_BAD_REQUEST);
        }
    }



    public function editPassword(Request $request, $id){
        $user = $this->userRepository->getById($id);
        if ($user) {
            if(strcmp($request['password'], $request['confirm_password'])  !== 0 ){
                return \response()->json(['message' => 'Veuillez confirmer le mot de passe'], Response::HTTP_BAD_REQUEST);
            } else {
                $request['password'] = Hash::make($request['password']);
                $user = $this->userRepository->update($id, $request->all());
                if($user)
                    return response()->json($user, Response::HTTP_OK);



            }
        }
        return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Display the specified User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
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

        $validator = Validator::make($request->all(), [
            //todo enter validation rules
            'telephone' => 'required'
        ]);
        if ($validator->fails())
            return response()->json([
                'message' => __('message.errors.field'), 'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        else {
            $user = $this->userRepository->getById($id);
            if ($user) {
                $user = $this->userRepository->update($user->id, $request->all());
                if ($user)
                    return response()->json($user, Response::HTTP_OK);

                return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
            }
            return response()->json(['message' => __('message.errors.update')], Response::HTTP_BAD_REQUEST);
        }
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
