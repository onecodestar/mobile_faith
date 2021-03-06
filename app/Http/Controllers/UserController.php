<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\FavoriteVerse;
use App\Following;
use App\Invite;
use App\Pray;
use Str, Input, File, Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = User::where('is_admin', 0)->get();
        return view('faith.user.index', ['records' => $records]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('faith.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();

        User::create($data);

        return redirect(url("/user"));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = User::find($id);
        return view('faith.user.edit', ['record' => $record]);
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
        $data = $request->all();
        if ($request->is_active) {
            $data['is_active'] = true;
        } else {
            $data['is_active'] = false;
        }

        $record = User::find($id);
        $record->update($data);

        return redirect(url("/user"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obj = User::find($id);
        $obj->delete();

        FavoriteVerse::where('user_id', $id)->delete();
        Invite::where('sender_id', $id)->orwhere('receiver_id', $id)->delete();
        Pray::where('user_id', $id)->delete();
        Following::where('user_id', $id)->delete();

        return redirect(url("/user"));
    }

    public function changepassword(Request $request, $id)
    {
        $record = User::find($id);
        return view('faith.user.changepassword', ['record' => $record]);
    }

    public function updatepassword(Request $request)
    {
        $record = User::find($request->id);
        if ($request->new_password == $request->confirm_password) {
            $record->update(['password' => Hash::make($request->new_password)]);
            return view('faith.user.changepassword', ['record' => $record])->with('success', 'Password Changed Successfully!');
        } else {
            return view('faith.user.changepassword', ['record' => $record])->with('error', 'Password Not Match. Try Again.');
        }
    }
}
