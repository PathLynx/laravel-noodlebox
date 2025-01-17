<?php

namespace App\Http\Controllers\Api\Wechat;

use App\Http\Controllers\Api\BaseController;
use App\Traits\WeChat\WechatDefaultConfig;
use Illuminate\Http\Request;

class MaterialController extends BaseController
{
    use WechatDefaultConfig;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function material(Request $request)
    {
        $material = $this->officialAccount()->material->get($request->input('media_id'));
        return json_success(['material' => $material]);
    }

    /**
     * @param Request $request
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function materials(Request $request)
    {
        if ($request->input('type') == 'news') {
            $items = [];
            $result = $this->officialAccount()->material->list(
                $request->input('type', 'image'),
                $request->input('offset', 0), 15);

            foreach ($result['item'] as $item) {
                $items[] = [
                    'media_id' => $item['media_id'],
                    'name' => $item['content']['news_item'][0]['title'],
                    'thumb_media_id' => $item['content']['news_item'][0]['thumb_media_id'],
                    'url' => $item['content']['news_item'][0]['url'],
                    'create_time' => date('Y-m-d H:i:s', $item['content']['create_time']),
                ];
            }
            return json_success([
                'total' => $result['total_count'],
                'items' => $items
            ]);
        } else {
            $result = $this->officialAccount()->material->list(
                $request->input('type', 'image'),
                $request->input('offset', 0), 15);
            return json_success([
                'total' => $result['total_count'],
                'items' => $result['item']
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(Request $request)
    {
        foreach ($request->input('ids', []) as $id) {
            $this->officialAccount()->material->delete($id);
        }
        return json_success();
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function image(Request $request)
    {
        return $this->officialAccount()->material->get($request->input('media_id'));
    }
}
