<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Carbon;
use App\Models\BookArea;

class TeamController extends Controller
{
    // Team controller 
    public function AllTeam(){
        $teams = Team::latest()->get();  // get data team

        return view('backend.team.all_team', compact('teams'));
    }

      // Add Team controller 
      public function AddTeam(){

        return view('backend.team.add_team');
      }

      // Add Data Team 
      public function TeamStore(Request $request){ 
        $image_name = '';
        //upload file photo
        if($request->file('image')){
            $file = $request->file('image');
            $image_name = date('YmdHi').'team.'.$file->getClientOriginalName(); //2003.avatar-2
            $file->move(public_path('upload/team'), $image_name);
            
        }
        Team:: insert([
            'name'=> $request->name,
            'position'=> $request->position,
            'facebook'=> $request->facebook,
            'image' => $image_name,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message'=> 'Team Data Inserted  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.team')->with($notification);
      }

      // Edit Team controller
      public function EditTeam($id){
        $team = Team::findOrFail($id);
        return view('backend.team.edit_team', compact('team'));
      }

      public function UpdateTeam(Request $request){
        $data = Team::find($request->id);
        $data->name = $request->name;
        $data->position = $request->position;
        $data->facebook = $request->facebook;
        //upload file photo
        if($request->file('image')){
            $file = $request->file('image');
            @unlink(public_path('upload/team/'.$data->image));
            $filename = date('YmdHi').'team.'.$file->getClientOriginalName(); //2003.avatar-2
            $file->move(public_path('upload/team'), $filename);
            $data['image'] = $filename;
        }
        $data->save();

        $notification = array(
            'message'=> 'Team Update Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.team')->with($notification);
      }

      public function DeleteTeam($id){
            $item = Team::findOrFail( $id);
            
            if($item->image){
                @unlink(public_path('upload/team/'.$item->image));
            }
            Team::findOrFail($id)->delete();
            $notification = array(
                'message'=> 'Delete Team Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
      }


      // ----- Book Area All Methods -----
      public function BookArea(){ 
        $book = BookArea::find(1);
        return view('backend.bookarea.book_area', compact('book'));

      }
      //update book area 
      public function UpdateBookArea(Request $request){ 
        $data = BookArea::find($request->id);
        $data->short_title = $request->short_title;
        $data->main_title = $request->main_title;
        $data->short_desc = $request->short_desc;
        
        $data->link_url = $request->link_url;
        //upload file photo
        if($request->file('images')){
            $file = $request->file('images');
            @unlink(public_path('upload/book_area/'.$data->images));
            $filename = date('YmdHi').'book_area.'.$file->getClientOriginalName(); //2003.avatar-2
            $file->move(public_path('upload/book_area'), $filename);
            $data['images'] = $filename;
        }
        $data->save();

        $notification = array(
            'message'=> 'Update Book Aera Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
      }
      
}
