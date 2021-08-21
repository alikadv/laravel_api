<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ///////////// Validating request ///////////
        $validator = Validator::make($request->all(), [
            'sort' => 'nullable|string|in:view_count,comment_count,created_at',
            'order' => 'nullable|string|in:asc,desc',
            'limit' => 'nullable|integer|min:0',
            'paginate' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1'
        ]);
        if ($validator->fails()) {
             return response()->json($validator->messages()->first(),400);
        }
        ////////////// Default values of request parameters ////////////

        $sort = ($request->has('sort')) ? $request->sort: 'created_at';
        $limit = ($request->has('limit')) ? $request->limit: '10';
        $paginate = ($request->has('paginate')) ? $request->paginate: null;
        $order = ($request->has('order')) ? $request->order: 'desc';
        $page = ($request->has('page')) ? $request->page: 1;

        if (!is_null($paginate)) {
            $art=Articles::select(DB::raw("*, 1337 as view_count"))->withCount('comments')->orderBy($sort,$order)->limit($limit)->paginate($paginate);
            $art->appends(['sort' => $sort,'limit' => $limit,'paginate' => $paginate,'order' => $order]);
        }else{
            $art=Articles::select(DB::raw("*, 1337 as view_count"))->withCount('comments')->orderBy($sort,$order)->limit($limit)->get();
        }

        $art->load('comments');

        return response()->json($art,200);
    }

    public function article_comments(Request $request, $id)
    {
        ///////////// Validating request ///////////
        $validator = Validator::make($request->all(), [
            'sort' => 'nullable|string|in:created_at',
            'order' => 'nullable|string|in:asc,desc'
        ]);
        if ($validator->fails()) {
             return response()->json($validator->messages()->first(),400);
        }
        ////////////// Default values of request parameters ////////////

        $sort = ($request->has('sort')) ? $request->sort: 'created_at';
        $order = ($request->has('order')) ? $request->order: 'desc';

        try {
            $art=Articles::findOrFail($id);
         }
         catch (ModelNotFoundException $e) {
            return response()->json(["Error"=>"Not found"],404);
         }

         $art->load('comments');


        return response()->json($art->comments,200);
    }

}
