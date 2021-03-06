<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meditate;
use Str, Input, File, Config;

class MeditateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Meditate::get();
        return view('faith.meditate.index', ['records' => $records]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('faith.meditate.create');
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
        //save title
        $title = [];
        foreach (Config::get('constants.languages') as $language) {
            $title[$language['code']] = $data['title_' . $language['code']];
        }
        $data['title'] = $title;
        //save thumbnail file
        $file = $request->file('thumbnail_file');
        $destinationPath = 'uploads/meditate/';
        $fileName = Str::random(5) . "." . $file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);
        $data['thumbnail_path'] = $destinationPath . $fileName;
        //save image file
        $file = $request->file('image_file');
        $destinationPath = 'uploads/meditate/';
        $fileName = Str::random(5) . "." . $file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);
        $data['image_path'] = $destinationPath . $fileName;
        //save audio file
        $file = $request->file('audio_file');
        $destinationPath = 'uploads/meditate/';
        $fileName = Str::random(5) . "." . $file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);
        $data['audio_path'] = $destinationPath . $fileName;

        Meditate::create($data);

        return redirect(url("/meditate"));
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
        $record = Meditate::find($id);
        return view('faith.meditate.edit', ['record' => $record]);
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
        $data['locked'] = $request->has('locked');

        $record = Meditate::find($id);

        //save title
        $title = $record->title;
        foreach (Config::get('constants.languages') as $language) {
            $title[$language['code']] = $data['title_' . $language['code']];
        }
        $data['title'] = $title;

        if ($request->file('thumbnail_file')) {
            $file = $request->file('thumbnail_file');
            $destinationPath = 'uploads/meditate/';
            $fileName = Str::random(5) . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);

            File::delete(public_path($record->thumbnail_path));

            $data['thumbnail_path'] = $destinationPath . $fileName;
        }

        if ($request->file('image_file')) {
            $file = $request->file('image_file');
            $destinationPath = 'uploads/meditate/';
            $fileName = Str::random(5) . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);

            File::delete(public_path($record->image_path));

            $data['image_path'] = $destinationPath . $fileName;
        }

        if ($request->file('audio_file')) {
            $file = $request->file('audio_file');
            $destinationPath = 'uploads/meditate/';
            $fileName = Str::random(5) . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);

            File::delete(public_path($record->audio_path));

            $data['audio_path'] = $destinationPath . $fileName;
        }

        $record->update($data);

        return redirect(url("/meditate"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obj = Meditate::find($id);
        File::delete(public_path($obj->thumbnail_path));
        File::delete(public_path($obj->image_path));
        File::delete(public_path($obj->audio_path));
        $obj->delete();

        return redirect(url("/meditate"));
    }
}
