<?php

namespace App\Http\Controllers\Web;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends BaseController
{
    /**
     * @param Request $request
     * @param $name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $slug)
    {
        $page = Page::whereSlug($slug)->first();

        if (!$page) {
            abort(404);
        }

        $view = 'web.page';
        if (view()->exists('web.page-' . $slug)) {
            $view = 'web.page-' . $slug;
        }

        if (view()->exists('web.page-' . $page->id)) {
            $view = 'web.page-' . $page->id;
        }

        return view($view, compact('page'));
    }
}
