<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class Post extends Controller
{
    public static function list() {
        $user_id = Auth::id();

        $friends = DB::table('user_relationship')
            ->where('is_like', '=', 1)
            ->orWhere('is_loved', '=', 1)
            ->having('from_user_id', '=', $user_id)
            ->get();

        $friend_id_arr = [];
        foreach($friends as $friend) {
            array_push($friend_id_arr, $friend->id);
        }

        $result = \App\Post::whereIn('posts.user_id', $friend_id_arr)
            ->leftjoin('users', 'posts.user_id', '=', 'users.id')
            ->leftjoin('post_photos', 'posts.id', '=', 'post_photos.post_id')
            ->leftjoin('user_photos', 'user_photos.id', '=', 'post_photos.photo_id')
            ->select('users.name AS author', 'users.avatar AS author_avatar', 'posts.*', 'user_photos.id AS photo_id', 'user_photos.source')
            ->orderBy('id', 'DESC')
            ->get();
        
        return json_encode($result);
    }

    public function getMyPosts() {
        $result = \App\Post::leftjoin('users', 'posts.user_id', '=', 'users.id')
            ->leftjoin('post_photos', 'posts.id', '=', 'post_photos.post_id')
            ->leftjoin('user_photos', 'user_photos.id', '=', 'post_photos.photo_id')
            ->select('users.name AS author', 'users.avatar AS author_avatar', 'posts.*', 'user_photos.id AS photo_id', 'user_photos.source')
            ->orderBy('id', 'DESC')
            ->having('posts.user_id', '=', $user_id)
            ->get();
        
        return json_encode($result);
    }

    public function like(Request $request, $post_id){
        $user_id = Auth::id();
        // $user_id = 1;
        $data = json_decode($request->getContent());

        $post = \App\Post::find($post_id);

        $type = $data->type;
        
        $return = array();
        if ($post->id){
            $oldData = $post->$type ? json_decode($post->$type) : [] ;
            
            if(in_array($user_id, $oldData)) {
                $return['message'] = "Lỗi. Bạn đã thích bài viết này trước đó.";
                return response()->json($return, 500);
            }
            $oldData[] = $user_id;
            $post->$type = json_encode($oldData);
            $result = $post->save();
            if ($result){
                $return['message'] = "Thành công";
                return response()->json($return, 200);
            }else{
                $return['message'] = "Có lỗi, vui lòng thử lại sau";
                return response()->json($return, 500);
            }
        }else{
            $return['message'] = "Bài viết không tồn tại";
            return response()->json($return, 404);
        }
    }

    public function unlike(Request $request, $post_id){
        $data = json_decode($request->getContent());
        $post = \App\Post::find($post_id);
        $type = $data->type;
        $return = array();
        if ($post->id){
            $oldData = $post->$type ? json_decode($post->$type) : [];
            foreach ($oldData as $key => $value){
                if ($value == Auth::id()){
                    unset($oldData[$key]);
                }
            }
            $post->$type = json_encode($oldData);
            $result = $post->save();
            if ($result){
                $return['message'] = "Thành công";
                return response()->json($return, 200);
            }else{
                $return['message'] = "Có lỗi, vui lòng thử lại sau";
                return response()->json($return, 500);

            }
        }else{
            $return['message'] = "Bài viết không tồn tại";
            return response()->json($return, 404);
        }
    }

    public function createPost(Request $request) {
        $user_id = Auth::id();
        $data = json_decode($request->getContent());

        $photo = null;
        if($data->image) {
            $base64_image = explode(',', $data->image)[1];

            $firstChar = substr($base64_image, 0, 1);

            switch($firstChar) {
                case '/': {
                    $extension = 'jpg';
                    break;
                }
                case 'i': {
                    $extension = 'png';
                    break;
                }
                case 'R': {
                    $extension = 'gif';
                    break;
                }
                default: {
                    $extension = 'jpg';
                    break;
                }
            }
    
            $filename = (string) time().'.'.$extension;
            
            Storage::disk('local')->put('user'.$user_id.'/photos/'.$filename, base64_decode($base64_image));
            $photo = \App\UserPhoto::create([
                'user_id' => $user_id,
                'source' => 'storage/app/user'.$user_id.'/photos/'.$filename
            ]);
        }
        
        $newPost = [
            'user_id' => $user_id,
            'content' => $data->content
        ];
        $post = \App\Post::create($newPost);

        if($photo) {
            DB::table('post_photos')->insert([
                'post_id' => $post->id,
                'photo_id' => $photo->id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);

            $post->photo_id = $photo->id;
            $post->source = $photo->source;
        }
        return json_encode($post);
    }
}
