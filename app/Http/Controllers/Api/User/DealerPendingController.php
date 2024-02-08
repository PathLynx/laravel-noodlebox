<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Models\UserDealerPending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealerPendingController extends BaseController
{
    /**
     * @return UserDealerPending|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return UserDealerPending::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $model = $this->repository()->where('id', Auth::id())->firstOrNew();
        $model->user()->associate(Auth::id());
        $model->save();

        return json_success();
    }
}
