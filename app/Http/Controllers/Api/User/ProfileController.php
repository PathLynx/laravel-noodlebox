<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends BaseController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $model = Auth::user()->profile()->firstOrCreate();
        return json_success($model);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $model = Auth::user()->profile()->firstOrCreate();
        $model->fill($request->input('profile', []))->save();
        return json_success($model);
    }
}
