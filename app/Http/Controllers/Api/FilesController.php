<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use App\Models\Download;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\File as FileResource;

class FilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission')->except(['index', 'download']);
    }

    /**
     * 获取文件列表
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return FileResource::collection(File::all());
    }

    /**
     * 更新文件信息
     *
     * @param File $file
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(File $file, Request $request)
    {
        $file->update($request->only('version'));

        return response(null, 204);
    }

    /**
     * 删除文件
     *
     * @param File $file
     * @return array
     * @throws \Exception
     */
    public function destroy(File $file)
    {
        Storage::delete($file->path);
        $file->delete();
        return response();
    }

    /**
     * 下载文件
     *
     * @param File $file
     * @param Request $request
     * @return mixed
     */
    public function download(File $file, Request $request)
    {
        if (!$request->has('t')) {
            abort(400, '缺少参数t');
        }

        // 记录下载
        Download::create([
            'file_id' => $file->id,
            'created_at' => Carbon::createFromTimestamp($request->get('t')),
        ]);

        // 发送下载链接
        return Storage::download($file->path);
    }

    /**
     * 重新遍历下载目录
     *
     * @return array
     */
    public function refresh()
    {
        // 将失效文件 available 属性设置为 false
        $files = File::all();
        foreach ($files as $file) {
            if (!file_exists($file->path)) {
                $file->update(['available' => false]);
            }
        }

        // 检查新文件
        $files = Storage::allFiles('/setups');
        foreach ($files as $file) {
            if (!File::where('path', $file)->first()) {
                $path_array = explode('/', $file);
                File::create([
                    'name' => end($path_array),
                    'path' => $file,
                    'size' => Storage::size($file),
                    'available' => true,
                ]);
            }
        }
        return response();
    }
}
