<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use function Pest\Laravel\json;
use function Pest\Laravel\post;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $posts = Post::all();
        /* return view("posts.index")->with("posts".$posts); */
        return view("posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /* $this->authorize('manageUser', User::class); */
        return view("posts.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:55',
            'description' => 'required|string|max:100',
            'image' => 'array|max:5',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        $imageName = "";
        $imageNames = [];
        if ($request->hasFile("image")) {
            $files = $request->file("image");
            foreach ($files as $file) {
                $imageName = $file->getClientOriginalName() . "-" . time() . "." . $file->getClientOriginalExtension();
                $file->move(public_path("/images/posts"), $imageName);
                $imageNames[] = $imageName;
            }
        }
        Post::create([
            "title" => $request->title,
            "description" => $request->description,
            "image" => json_encode($imageNames)

        ]);
        return redirect()->route("posts.index");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $posts = Post::findOrFail($id);
        return view("posts.show", compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        $posts = Post::findOrFail($id);
        return view('posts.edit', compact('posts'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:55',
            'description' => 'required|string|max:100',
            'image' => 'array|max:5',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);
        $post = Post::findOrFail($id);
        $imageNames = json_decode($post->image);

        if ($imageNames) {
            foreach ($imageNames as $oldImage) {
                if (File::exists(public_path('/images/posts/' . $oldImage))) {
                    File::delete(public_path('/images/posts/' . $oldImage));
                }
            }
            $imageNames = [];
        }
        if ($request->hasFile('image')) {
            $files = $request->file("image");
            foreach ($files as $file) {
                $imageName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('/images/posts'), $imageName);
                $imageNames[] = $imageName;
            }
        }
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => json_encode($imageNames)
        ]);
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorize('manageUser', User::class);

        $post_id = Post::findOrFail($id);
        /* $oldImage = $post_id->image;
 */
        $imageNames = json_decode($post_id->image);

        if ($post_id->delete()) {
            if ($imageNames) {
                foreach ($imageNames as $oldImage) {
                    if (File::exists(public_path('/images/posts/' . $oldImage))) {
                        File::delete(public_path('/images/posts/' . $oldImage));
                    }
                }
            }
            return redirect()->route("posts.index");
        }
    }
}
