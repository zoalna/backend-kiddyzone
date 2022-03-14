@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Partners
            </h6>
            <div class="ml-auto">
                @can('create_category')
                <a href="{{ route('admin.partners.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">New Partner</span>
                </a>
                @endcan
            </div>
        </div>
        <!-- @include('partials.backend.filter', ['model' => route('admin.categories.index')]) -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($partners as $partner)
                    <tr>
                        <td>{{ $partner->id }}</td>
                        <td>{{ $partner->name }}</td>
                        <td>{{ $partner->description }}</td>
                        <td>
                            @if($partner->image_url)
                                <img src="{{ asset('storage/images/partners/' . $partner->image_url) }}"
                                     width="60" height="60" alt="{{ $partner->image_url }}">
                            @else
                                <img src="{{ asset('img/no-img.png') }}" width="60" height="60" alt="{{ $partner->name }}">
                            @endif
                        </td>
                        <td><a href="{{ route('admin.partners.show', $partner->id) }}">
                            </a>
                        </td>
                        
                        <td>{{ $partner->created_at }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.partners.edit', $partners) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:void(0);"
                                   onclick="if (confirm('Are you sure to delete this record?'))
                                   {document.getElementById('delete-category-{{ $partner->id }}').submit();} else {return false;}"
                                   class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                            <form action="{{ route('admin.partners.destroy', $partner) }}"
                                  method="POST"
                                  id="delete-category-{{ $partner->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="6">No categories found.</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="float-right">
                                {!! $partners->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
