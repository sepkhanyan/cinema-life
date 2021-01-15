@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Cinemas</div>

                    <div class="card-body">
                            <div>
                                @if(count($cinemas))
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Address</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($cinemas as $cinema)
                                            <tr>
                                                <td>
                                                    {{ $cinema['title'] }}
                                                </td>
                                                <td>
                                                    {{ $cinema['address'] }}
                                                </td>
                                                <td class="text-center">
                                                    <a role="button" class="btn btn-primary "
                                                       href="{{ url('/cinemas/' . $cinema['id'] . '/edit') }}">
                                                        Edit
                                                    </a>

                                                    <a role="button" class="btn btn-info "
                                                       href="{{ url('/cinemas/' . $cinema['id']) }}">
                                                        Show
                                                    </a>

                                                    <a role="button" class="btn btn-danger " href="javascript:void(0);" onclick="$(this).find('form').submit();" >
                                                        <form action="{{ url('/cinemas/' . $cinema['id']) }}" method="POST">
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
                                    No Cinemas
                                @endif
                            </div>
                    </div>
                </div>
                <div class="mt-5">
                    <a href="{{url('cinemas/create')}}" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
    </div>
@endsection