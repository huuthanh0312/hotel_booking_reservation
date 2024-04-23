<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;
class BlogCategoryController extends Controller
{
    // BlogCategory controller 
    public function AllBlogCategory(){
        $blog_categories = BlogCategory::latest()->get();  // get data team

        return view('backend.category.all_blog_category', compact('blog_categories'));
    }

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
      }

      // Edit BlogCategory controller
      public function EditBlogCategory($id){
        $blog_category = BlogCategory::findOrFail($id);
        return response()->json($blog_category);
      }

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
      }

      public function DeleteBlogCategory($id){
                       
            BlogCategory::findOrFail($id)->delete();
            $notification = array(
                'message'=> 'Delete Blog Category Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
      }


      

}
