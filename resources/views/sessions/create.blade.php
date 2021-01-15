@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New Session</div>

                    <div class="card-body">
                        <div>
                            <form method="POST" action="{{ url('/sessions') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 @error('movie_id') text-danger @enderror">
                                    <select class="form-select" name="movie_id" aria-label="Select movie">
                                        @foreach($movies as $movie)
                                            <option value="{{$movie['id']}}">{{$movie['title']}}</option>
                                        @endforeach
                                    </select>
                                    @error('movie_id')
                                    <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 @error('hall_id') text-danger @enderror">
                                    <select class="form-select" name="hall_id" aria-label="Select hall">
                                        @foreach($halls as $hall)
                                            <option value="{{$hall['id']}}">{{$hall['title']}}</option>
                                        @endforeach
                                    </select>
                                    @error('hall_id')
                                    <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 @error('start_time') text-danger @enderror">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="datetime-local" name="start_time" class="form-control" id="start_time" value="{{old('start_time')}}">
                                </div>
                                <div class="mb-3 @error('end_time') text-danger @enderror">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="datetime-local" name="end_time" class="form-control" id="end_time" value="{{old('end_time')}}">
                                    @error('start_time')
                                    <div>{{ $message }}</div>
                                    @enderror
                                    @error('end_time')
                                    <div>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary mb-3">Save</button>
                                </div>
                            </form>
                        </div>
                        @if (session('active_session'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('active_session') }}
                            </div>
                            {{session()->forget('active_session')}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection