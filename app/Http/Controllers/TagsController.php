<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\tags;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        ///////////// Validating request ///////////
        $validator = Validator::make($request->all(), [
            'sort' => 'nullable|string|in:articles_count,id,title', // created_at ველი არ არსებობს ტეგებში
            'order' => 'nullable|string|in:asc,desc'
        ]);
        if ($validator->fails()) {
             return response()->json($validator->messages()->first(),400);
        }
        ////////////// Default values of request parameters ////////////

        $sort = ($request->has('sort')) ? $request->sort: 'articles_count';
        $order = ($request->has('order')) ? $request->order: 'desc';


        $tags=tags::withCount('Articles')->orderBy($sort,$order)->get();

        //$tags->load('Articles'); // შეგვიძლია არტიცლებიც გავატანოთ, თუმცა დავალებაში არ იყო მოთხოვილი

        return response()->json($tags,200);
    }

    public function tags_articles(Request $request, $id)
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
            $tags=tags::where('id',$id)->with(array('Articles' => function($query) {
                $query->orderBy('created_at', 'desc');
            }))->get();
         }
         catch (ModelNotFoundException $e) {
            return response()->json(["Error"=>"Not found"],404);
         }



        return response()->json($tags[0]->articles,200);
    }

}
