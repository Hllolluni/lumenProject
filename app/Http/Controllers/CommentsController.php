<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function getComments($postId){
        $post = Post::findOrFail($postId);
        $id = $post->id();
        return Comment::with($id)->get()->all();
    }

    public function store(Request $request, $id){
        try {
            $comment = new Comment();
            $comment -> body = $request->body;
            $comment->post_Id = $id;
            $comment->user_Id = Auth::id();

            if ($comment->save()){
                return response()->json(['status'=>'success', 'message'=>'Comment created successfully']);
            }
        }catch (Exception $exception){
            return response()->json(['status'=>'error', 'message'=>$exception->getMessage()]);
        }
    }

    public function delete($id){
        try{
            $comment = Comment::findOrFail($id);

            if(Auth::user()->id !== $comment->user_Id){
                return response()->json(['status'=>'fail', 'message'=>'Unauthorized to edit the post']);
            }
            if ($comment->delete()){
                return response()->json(['status'=>'success', 'message'=>'Post deleted successfully']);
            }
        }catch(\Exception $exception){
            return response()->json(['status'=>'error', 'message'=>$exception->getMessage()]);
        }
    }


}
