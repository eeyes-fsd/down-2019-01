<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Http\Resources\Item as ItemResource;
use App\Handlers\ImageUploadHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemsController extends Controller
{
    public function index()
    {
        $items = Item::all();

        return ItemResource::collection($items);
    }

    public function store(ItemRequest $request)
    {
        Item::create($request->only([
            'name',
            'description',
            'crack',
            'rank',
            'mac_id',
            'win_id',
            'icon_path',
            'enable',
        ]));

        return response(null, 201);
    }

    /**
     * @param Request $request
     * @param ImageUploadHandler $handler
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function upload_icon(Request $request, ImageUploadHandler $handler)
    {
        if ($request->hasFile('icon') && $request->file('icon')->isValid()) {
            $result = $handler->save($request->file('icon'), 'icon');
            if ($result) {
                return response(null, 201, ['Location' => $result]);
            }
        }
        return response(null, 400);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_icon()
    {
        $icons = Storage::allFiles('public/icon');

        return response()->json($icons, 200);
    }
}
