<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RelatedSitesResource;
use App\Models\RelatedNewsSite;
use Illuminate\Http\Request;

class RelatedSitesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $related_news = RelatedNewsSite::get();

        if (!$related_news) {
            return apiResponse(404, 'Related News Is Empty');
        }
        return apiResponse(
            200,
            'this is related sites',
            ['related_sites' => RelatedSitesResource::collection($related_news)]
        );
    }
}
