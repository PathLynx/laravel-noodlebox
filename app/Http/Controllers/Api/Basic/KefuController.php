<?php

namespace App\Http\Controllers\Api\Basic;

use App\Http\Controllers\Api\BaseController;
use App\Models\Kefu;
use Illuminate\Http\Request;

class KefuController extends BaseController
{
    /**
     * @return Kefu|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Kefu::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request)
    {
        $kefu = $this->repository()->find($request->input('id'));
        return json_success($kefu);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request)
    {
        $query = $this->repository();
        return json_success([
            'total' => $query->count(),
            'items' => $query->get()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $kefu = $this->repository()->findOrNew($request->input('id'));
        $kefu->fill($request->input('kefu', []))->save();

        return json_success($kefu);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDelete(Request $request)
    {
        $this->repository()->whereKey($request->input('items', []))->delete();
        return json_success();
    }
}