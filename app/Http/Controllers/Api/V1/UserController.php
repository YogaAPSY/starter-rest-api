<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use App\Http\Requests\storeUserRequest;
use App\Http\Requests\updateUserRequest;

class UserController extends Controller
{

    protected $service;
    protected $db;
    public function __construct(UserService $service)
    {
        $this->db = app('db');
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = UserService::listUserService();
        return responder()->success($user, UserTransformer::class)->respond();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeUserRequest $request)
    {
        $request->validated();
        return $this->service->storeUserService($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $User
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $showUser = $this->service->showUserService($id);
        return responder()->success($showUser, UserTransformer::class)->respond(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $User
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User                $User
     * @return \Illuminate\Http\Response
     */
    public function update(updateUserRequest $request, $id)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $this->service->updateUserService($request->all(), $id);
            DB::commit();
            return responder()->success('sdsd', UserTransformer::class)->respond(202);
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $User
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return $this->service->destroyUserService($id);
    }
}
