<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Carbon\Carbon;

class BannerController extends Controller
{
    private $type = 'banner';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::select(['uuid', 'title', 'image', 'target'])
            ->where([
                ['start_datetime', '<=', Carbon::now()],
                ['end_datetime', '>=', Carbon::now()],
            ])
            ->where('is_active', 1)
            ->orderBy('ordinal_no')
            ->get();

        if (count($banners) <= 0) {
            return response()->json(['status' => '404', 'data' => $banners], 200);
        }

        return response()->json(['status' => '200', 'data' => $banners], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = Banner::query()
            ->select(['uuid', 'title', 'image', 'target'])
            ->where('is_active', 1)
            ->find($id);

        if (!$banner) {
            return response()->json(['status' => '404', 'data' => $banner], 200);
        }

        return response()->json(['status' => '200', 'data' => $banner], 200);
    }
}
