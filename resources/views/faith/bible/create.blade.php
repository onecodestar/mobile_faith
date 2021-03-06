@extends('layouts.master-layouts')

@section('title')
    Add Bible
@endsection

@section('css')
    <!-- Summernote css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote.min.css') }}">
@endsection

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Add Bible</h4>

                    <form action="/bible" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Language</label>
                            <select class="form-control" name="language">
                                @foreach (Config::get('constants.bible_languages') as $language)
                                    <option value="{{ $language }}">{{ $language }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>DamID</label>
                            <input type="text" class="form-control" name="damID" required>
                        </div>
                        <div class="form-group">
                            <label>Volume Name</label>
                            <input type="text" class="form-control" name="volume_name" required>
                        </div>
                        <div class="form-group">
                            <label>BookID</label>
                            <input type="text" class="form-control" name="bookID" required>
                        </div>
                        <div class="form-group">
                            <label>ChapterID</label>
                            <input type="text" class="form-control" name="chapterID" required>
                        </div>
                        <div class="form-group">
                            <label>Audio File</label>
                            <input type="file" name="audio_file" accept=".mp3" required>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->


@endsection

@section('script')
    <!-- Summernote js -->
    <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js') }}"></script>

    <script>
        $(".summernote").summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: !0
        });

    </script>
@endsection
