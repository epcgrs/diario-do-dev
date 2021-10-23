<?php

namespace App\Http\Controllers\API;

use App\Core\API\Services\Contracts\IContentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /* @var IContentService */
    protected $contentService;

    public function __construct(IContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    public function paginateMaster()
    {
        if ($contents = $this->contentService->paginateMaster(10)) {
            return response()->json([
                'status' => true,
                'contents' => $contents
            ]);
        }
        return response()->json([
            'status' => false,
            'contents' => NULL
        ]);
    }

    public function save(Request $request)
    {
        if ($savedContent = $this->contentService->save($request->all())) {
            return response()->json([
                'status' => true,
                'content' => $savedContent
            ]);
        }

        return response()->json([
            'status' => false,
            'content' => NULL
        ]);
    }
}
