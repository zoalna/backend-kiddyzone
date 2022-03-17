@extends('layouts.admin')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Age: ({{ $ages->id }})
            </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.ages.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Back to categories</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ages.update', $ages) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" id="name" type="text" name="from_age" value="{{ old('name', $ages->from_age) }}">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" id="name" type="text" name="to_age" value="{{ old('name', $ages->to_age) }}">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="row">
                        <div class="col-12">
                            <label for="cover">Cover image</label><br>
                            @if($ages->image_url)
                                <img
                                    class="mb-2"
                                    src="{{ asset('storage/images/ages/' . $ages->image_url) }}"
                                    alt="{{ $ages->image_url }}" width="100" height="100">
                                <a  class="btn btn-sm btn-danger mb-2"
                                    href="{{ route('admin.categories.remove_image', $ages->id) }}">Remove</a>
                            @else
                                <img
                                    class="mb-2"
                                    src="{{ asset('img/no-img.png') }}" alt="{{ $ages->name }}" width="60" height="60">
                            @endif
                            <br>
                            <input type="file" name="cover">
                            <span class="form-text text-muted">Image width should be 500px x 500px</span>
                            @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button class="btn btn-primary" type="submit" name="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
