@extends('admin-layout.app')
@section('title', 'dashboard')
@section('content')


<div class="container-fluid">

    <!-- row -->
    <div class="row column1 mt-5">
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class=" d-flex heading1 margin_0">
                        <h2>Customers</h2>
                        <a href="{{ route('users.create') }}" class="btn  btn-lg "
                            style="margin-left: 785px;background-color:#15283c;color:white">Add New User</a>
                    </div>
                </div>
                <div class="full price_table padding_infor_info">
                <div class="row" >
                        <div class="col-md-6 mx-auto" >
                            <form action="{{ route('users.index') }}" method="GET"  >
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Search products"
                                        value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-lg" style="margin-left:4px;background-color:#15283c; color:white"
                                            type="submit">Search</button>
                                        <!-- Reset Button -->
                                        <a href="{{ route('users.index') }}" class="btn btn-lg"
                                            style=" margin-left:5px;background-color:#d9534f; color:white;">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive-sm">
                                <table class="table table-striped projects">
                                    <thead class="thead-dark text-center">
                                        <tr>
                                            <th style="width: 2%">No</th>
                                            <th>Profile_Picture</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                           
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($users as $index => $user)
                                            <tr>
                                            <td>{{ $index + 1 + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                            <td >
                                                    @if($user->profile_picture)
                                                        <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                                            alt="Profile Picture"
                                                            style="width: 50px; height: 50px; border-radius: 50%;">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>    
                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                <td>{{ $user->email }}</td>
                                                
                                                <td>
                                                
                                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                                            <i class="fa fa-trash"></i> 
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br><br><br>

                                <!-- Pagination links -->
                                <div class="d-flex justify-content-center">
                                    {{ $users->links('pagination::bootstrap-5') }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>

</div>

@endsection