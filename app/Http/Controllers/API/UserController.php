<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


  public function __construct()
   {
       $this->middleware('auth:api');

   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          // $this->authorize('isAdmin');
          if (\Gate::allows('isAdmin')|| \Gate::allows('isAuthor')) {
            // code...
            return User::latest()->paginate(20);
          }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
        'name'=>'required|string|max:191',
        'email'=>'required|unique:users|string|max:191',
        'password'=>'required|string|min:6',
      ]);
        return User::create([
          'name'=>$request['name'],
          'email'=>$request['email'],
          'type'=>$request['type'],
          'biography'=>$request['biography'],
          'photo'=>$request['photo'],
          'password'=>Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {

       return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        $user= auth('api')->user();

        $this->validate($request,[
          'name'=>'required|string|max:191',
          'email'=>'required|string|max:191|unique:users,email,'.$user->id,
          'password'=>'sometimes|min:6',
        ]);

        $currentPhoto=$user->photo;
        if($request->photo !=$currentPhoto){
        $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
        \Image::make($request->photo)->save(public_path('img/profilePhoto/').$name);
        $request->merge(['photo' => $name]);
        // $userOldPhoto=public_path('img/profile/profilePhoto/').$currentPhoto;

        $useroldPhoto = public_path('img/profilePhoto/').$currentPhoto;
           if(file_exists($useroldPhoto)){
               @unlink($useroldPhoto);
           }
        }
        if(!empty($request->password)){
          $request->merge(['password' => Hash::make($request['password'])]);
    }

        $user->update($request->all());

      return ['messaage'=>' Profile Updated   successfully'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);

      $this->validate($request,[
        'name'=>'required|string|max:191',
        'email'=>'required|string|max:191|unique:users,email,'.$user->id,
        'password'=>'sometimes|min:6',
      ]);
      if(!empty($request->password)){
        $request->merge(['password' => Hash::make($request['password'])]);
      }

      $user->update($request->all());

      return ['messaage'=>'Updated User successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->authorize('isAdmin');
      $user=User::findOrFail($id);

      $user->delete();
      return ['message'=>'User Deleted'];

    }
    public function search(){
       if ($search = \Request::get('q')) {
           $users = User::where(function($query) use ($search){
               $query->where('name','LIKE',"%$search%")
                       ->orWhere('email','LIKE',"%$search%")
                       ->orWhere('type','LIKE',"%$search%")
                       ->orWhere('biography','LIKE',"%$search%");
           })->paginate(20);
       }else{
           $users = User::latest()->paginate(20);
       }
       return $users;
   }
}
