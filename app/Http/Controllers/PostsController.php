<?php


namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Diff\Exception;


class PostsController extends Controller
{

    public function getPosts(){
        return Post::all();
    }

    public function getComments($id){
        return Post::find($id)->theComments;
    }

    public function store(Request $request){
        try {
            $post = new Post();
            $post -> title = $request->title;
            $post->body = $request->body;
            $post->user_Id = Auth::id();

            if ($post->save()){
                return response()->json(['status'=>'success', 'message'=>'Post created successfully']);
            }
        }catch (Exception $exception){
            return response()->json(['status'=>'error', 'message'=>$exception->getMessage()]);
        }
    }

    public function update(Request $request, $id){
        try {
            $post = Post::findOrFail($id);
            $post -> title = $request->title;
            $post->body = $request->body;

            if(Auth::user()->id !== $post->user_Id){
                return response()->json(['status'=>'fail', 'message'=>'Unauthorized to edit the post']);
            }

            if ($post->save()){
                return response()->json(['status'=>'success', 'message'=>'Post updated successfully']);
            }
        }catch (Exception $exception){
            return response()->json(['status'=>'error', 'message'=>$exception->getMessage()]);
        }
    }

    public function delete(Request $request, $id){
        try{
            $post = Post::findOrFail($id);

            if(Auth::user()->id !== $post->user_Id){
                return response()->json(['status'=>'fail', 'message'=>'Unauthorized to edit the post']);
            }
            if ($post->delete()){
                return response()->json(['status'=>'success', 'message'=>'Post deleted successfully']);
            }
        }catch(\Exception $exception){
            return response()->json(['status'=>'error', 'message'=>$exception->getMessage()]);
        }
    }

    public function deleteAdmin(Request $request, $id){
        try{
            $post = Post::findOrFail($id);

            if(Auth::user()->id !== $post->user_Id){
                return response()->json(['status'=>'fail', 'message'=>'Unauthorized to edit the post']);
            }
            if ($post->delete()){
                return response()->json(['status'=>'success', 'message'=>'Post deleted successfully']);
            }
        }catch(\Exception $exception){
            return response()->json(['status'=>'error', 'message'=>$exception->getMessage()]);
        }
    }
}
