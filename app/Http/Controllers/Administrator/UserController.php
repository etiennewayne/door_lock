<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index(){
        return view('administrator.user'); //blade.php
    }

    public function getUsers(Request $req){
        $sort = explode('.', $req->sort_by);

        $users = User::where('lname', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $users;
    }

    public function show($id){
        return User::find($id);
    }

    public function store(Request $req){
        //this will create random unique QR code
        $qr_code = substr(md5(time() . $req->lname . $req->fname), -8);

        $validate = $req->validate([
            'rfid' => ['required', 'max:50', 'unique:users'],
            'username' => ['required', 'max:50', 'unique:users'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'confirmed'],
            'role' => ['required', 'string'],
        ]);

        User::create([
            'rfid' => $req->rfid,
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'lname' => strtoupper($req->lname),
            'fname' => strtoupper($req->fname),
            'mname' => strtoupper($req->mname),
            'sex' => $req->sex,
            'contact_no' => $req->contact_no,
            'role' => $req->role,
        ]);

        return response()->json([
            'status' => 'saved'
        ]);
    }

    public function update(Request $req, $id){
        $validate = $req->validate([

            'rfid' => ['required', 'max:50', 'unique:users,rfid,'.$id.',user_id'],
            'username' => ['required', 'max:50', 'unique:users,username,'.$id.',user_id'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'contact_no' => ['required', 'string', 'max:20'],
            'role' => ['required', 'string'],

        ]);

        $data = User::find($id);
        $data->rfid = $req->rfid;
        $data->username = $req->username;
        $data->lname = strtoupper($req->lname);
        $data->fname = strtoupper($req->fname);
        $data->mname = strtoupper($req->mname);
        $data->contact_no = $req->contact_no;
        $data->sex = $req->sex;

        $data->role = $req->role;

        $data->save();

        return response()->json([
            'status' => 'updated'
        ]);
    }


    public function getBrowseDentist(Request $req){

        $data = User::where('lname', 'like', $req->lname . '%')
            ->where('fname', 'like', $req->fname . '%')
            ->where('role', 'DENTIST')
            ->paginate($req->perpage);
        return $data;
    }

    public function resetPassword(Request $req, $id){

        $req->validate([
            'password' => ['required', 'confirmed']
        ]);

//        if($req->password != $req->password_confirmation){
//            return response()->json([
//                'status' => 'not_matched'
//            ], 422);
//        }

        $user = User::find($id);
        $user->password = Hash::make($req->password);
        $user->save();

        return response()->json([
            'status' => 'changed'
        ],200);


    }

    public function destroy($id){
        User::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ],200);
    }
}
