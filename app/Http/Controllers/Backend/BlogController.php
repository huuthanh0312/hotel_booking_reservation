<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    // BlogCategory controller 
    public function AllBlogCategory(){
        $blog_categories = BlogCategory::latest()->get();  // get data team

        return view('backend.category.all_blog_category', compact('blog_categories'));
    }//end methods

      // Add Data BlogCategory 
    public function StoreBlogCategory(Request $request){ 
    
        BlogCategory:: insert([
            'category_name'=> $request->category_name,
            'category_slug'=> strtolower(str_replace(' ', '-', $request->category_name)), /// replace ' ' => '-',
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message'=> 'Blog Category Data Inserted  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }//end methods

    // Edit BlogCategory controller
    public function EditBlogCategory($id){
        $blog_category = BlogCategory::findOrFail($id);
        return response()->json($blog_category);
    }//end methods
        // Update BlogCategory
    public function UpdateBlogCategory(Request $request){
        $data = BlogCategory::find($request->id);
        $data->category_name = $request->category_name;
        $data->category_slug = strtolower(str_replace(' ', '-', $request->category_name));  /// replace ' ' => '-',  
        $data->save();

        $notification = array(
            'message'=> 'Blog Category Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('blog.category.all')->with($notification);
    }//end methods

    // Delete BlogCategory
    public function DeleteBlogCategory($id){
                    
        BlogCategory::findOrFail($id)->delete();
        $notification = array(
            'message'=> 'Delete Blog Category Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }//end methods

    ////////////////////// Blog Post /////////////////////
    // List Post
    public function AllBlogPost(){
        $posts = BlogPost::latest()->get();  // get data team

        return view('backend.post.all_post', compact('posts'));
    }//end methods

    // add Post
    public function AddBlogPost(){
        $blog_category = BlogCategory::latest()->get(); // get data
        return view('backend.post.add_post', compact('blog_category'));
    }

    // Add Data Post 
    public function StoreBlogPost(Request $request){ 
        $image_name = '';
        //upload file photo
        if($request->file('post_image')){
            $file = $request->file('post_image');
            $image_name = date('YmdHi').'_post.'.$file->getClientOriginalName(); //2003.avatar-2
            $file->move(public_path('upload/post'), $image_name);
            
        }
        BlogPost:: insert([
            'blogcat_id'=> $request->blogcat_id,
            'user_id'=> Auth::user()->id,
            'post_title'=> $request->post_title,
            'post_slug'=> strtolower(str_replace(' ', '-', $request->post_title)), /// replace ' ' => '-',$request->post_slug,
            'post_image'=> 'upload/post/'.$image_name,
            'short_descp'=> $request->short_descp,
            'long_descp'=> $request->long_descp,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message'=> 'Blog Post Data Inserted  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('blog.post.all')->with($notification);
        }//end methods

        // Edit Post 
        public function EditBlogPost($id){
        $blog_category = BlogCategory::latest()->get();
        $post= BlogPost::findOrFail($id);
        return view('backend.post.edit_post', compact('post', 'blog_category'));
    }//end methods

    // Update Post
    public function UpdateBlogPost(Request $request){
        $data = BlogPost::find($request->id);
        $data->blogcat_id = $request->blogcat_id;
        $data->post_title = $request->post_title;
        $data->post_slug = strtolower(str_replace(' ', '-', $request->post_title));
        $data->short_descp = $request->short_descp;
        $data->long_descp = $request->long_descp;
        
        //upload file photo
        if($request->file('post_image')){
            $file = $request->file('post_image');
            @unlink(public_path($data->post_image));
            $filename = date('YmdHi').'_post.'.$file->getClientOriginalName(); //2003.avatar-2
            $file->move(public_path('upload/post'), $filename);
            $data['post_image'] = 'upload/post/'.$filename;
        }
        $data->updated_at = Carbon::now();

        $data->save();

        $notification = array(
            'message'=> 'Blog Post Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('blog.post.all')->with($notification);
    }//end methods
    // Delete BlogCategory
    public function DeleteBlogPost($id){
        $post = BlogPost::findOrFail($id); 
        if($post->post_image)  {
            @unlink(public_path($post->post_image));
        }  
        
        $post->delete();
        $notification = array(
            'message'=> 'Delete Blog Post Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }//end methods

    ///////////// Frontend Post Details ////////////////

    // blog details
    public function BlogDetails($slug){
        $post = BlogPost::where('post_slug', $slug)->first();
        $blog_category = BlogCategory::latest()->get();
        $list_post_diff = BlogPost::latest()->limit(3)->get();
        return view('frontend.blog.blog_details', compact('post', 'blog_category', 'list_post_diff'));
    }

    //blog category in list
    public function BlogCatList($id){
        $blog_category = BlogCategory::latest()->get();
        $list_post_diff = BlogPost::latest()->limit(3)->get();
        $blog_category_find = BlogCategory::find($id);
        $blog = BlogPost::where('blogcat_id', $id)->get();
        return view('frontend.blog.blog_cat_list', compact('blog', 'blog_category', 'list_post_diff', 'blog_category_find'));
    }
    
    /// list all blog categories
    public function BlogList(){
        $blog_category = BlogCategory::latest()->get();
        $list_post_diff = BlogPost::latest()->limit(3)->get();      
        $blog = BlogPost::latest()->paginate(4); 
        return view('frontend.blog.blog_all', compact('blog', 'blog_category', 'list_post_diff'));
    }

}