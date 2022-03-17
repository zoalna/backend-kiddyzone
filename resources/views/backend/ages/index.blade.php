@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Ages
            </h6>
            <div class="ml-auto">
                @can('create_category')
                <a href="{{ route('admin.ages.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">New Age</span>
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
                    <th>From age</th>
                    <th>To age</th>
                    <th>Image</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($ages as $age)
                    <tr>
                        <td>{{ $age->id }}</td>
                        <td>{{ $age->from_age }}</td>
                        <td>{{ $age->to_age }}</td>
                        <td>
                            @if($age->image_url)
                                <img src="{{ asset('storage/images/ages/' . $age->image_url) }}"
                                     width="60" height="60" alt="{{ $age->image_url }}">
                            @else
                                <img src="{{ asset('img/no-img.png') }}" width="60" height="60" alt="{{ $age->name }}">
                            @endif
                        </td>
                        <td><a href="{{ route('admin.categories.show', $age->id) }}">
                            </a>
                        </td>
                        
                        <td>{{ $age->created_at }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.ages.edit', $age) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:void(0);"
                                   onclick="if (confirm('Are you sure to delete this record?'))
                                   {document.getElementById('delete-category-{{ $age->id }}').submit();} else {return false;}"
                                   class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                            <form action="{{ route('admin.ages.destroy', $age) }}"
                                  method="POST"
                                  id="delete-category-{{ $age->id }}" class="d-none">
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
                                {!! $ages->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
