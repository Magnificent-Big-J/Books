@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Authors</div>

                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>Date Of Birth</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($authors as $author)
                                    <tr>
                                        <td>{{$author->id}}</td>
                                        <td>{{$author->name}}</td>
                                        <td>{{$author->surname}}</td>
                                        <td>{{$author->dob}}</td>
                                        <td colspan="2">
                                            <a class="btn btn-sm btn-info" href="">View</a>
                                            <a class="btn btn-sm btn-danger" href="">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
