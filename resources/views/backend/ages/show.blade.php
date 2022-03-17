@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ $ages->name }}
            </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.ages.index') }}" class="btn btn-primary">
                    <span class="text">Back to Ages</span>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>From age</th>
                    <th>To age</th>
                    <th>Image</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $ages->id }}</td>
                    <td>{{ $ages->from_age }}</td>
                    <td>{{ $ages->to_age }}</td>
                    <td>{{ $ages->created_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
