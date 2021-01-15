@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Sessions</div>

                    <div class="card-body">
                            <div>
                                @if(count($sessions))
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Cinema</th>
                                            <th scope="col">Movie</th>
                                            <th scope="col">Hall</th>
                                            <th scope="col">Start Time</th>
                                            <th scope="col">End Time</th>
                                            <th scope="col" class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sessions as $session)
                                            <tr>
                                                <td>
                                                    {{ $session->movie->cinema['title'] }}
                                                </td>
                                                <td>
                                                    {{ $session->movie['title'] }}
                                                </td>
                                                <td>
                                                    {{ $session->hall['title'] }}
                                                </td>
                                                <td>
                                                    {{ $session['start_time'] }}
                                                </td>
                                                <td>
                                                    {{ $session['end_time'] }}
                                                </td>
                                                <td class="text-center">
                                                    <a role="button" class="btn btn-primary "
                                                       href="{{ url('/sessions/' . $session['id'] . '/edit') }}">
                                                        Edit
                                                    </a>

                                                    <a role="button" class="btn btn-info "
                                                       href="{{ url('/sessions/' . $session['id']) }}">
                                                        Show
                                                    </a>

                                                    <a role="button" class="btn btn-danger " href="javascript:void(0);" onclick="$(this).find('form').submit();" >
                                                        <form action="{{ url('/sessions/' . $session['id']) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            Delete
                                                        </form>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    No sessions
                                @endif
                            </div>
                    </div>
                </div>
                <div class="mt-5">
                    <a href="{{url('sessions/create')}}" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
    </div>
@endsection