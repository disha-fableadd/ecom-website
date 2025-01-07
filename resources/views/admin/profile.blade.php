@extends('admin-layout.app')
@section('title', 'dashboard')
@section('content')


<div class="container-fluid">

    <!-- user profile section -->
    <div class="row mt-5">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>User Profile</h2>
                    </div>
                </div>
                <div class="full price_table padding_infor_info">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="full dis_flex center_text">
                                <div class="profile_img">
                                    <img width="180" class="rounded-circle"
                                        src="{{ asset('storage/' . $user->profile_picture) }}" alt="#" />
                                </div>
                                <div class="profile_contant">
                                    <div class="contact_inner">
                                        <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>

                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-envelope-o"></i> : {{ $user->email }}</li><br><br>
                                            <li><i class="fa fa-phone"></i> : {{ $user->mobile ?? 'Phone not set' }}
                                            </li><br><br>
                                            <li><i class="fa fa-calendar"></i> : {{ $user->age ?? 'Age not set' }}</li><br><br>
                                            <!-- Age -->
                                            <li><i class="fa fa-venus-mars"></i> :
                                                {{ $user->gender ?? 'Gender not set' }}</li> <!-- Gender --><br><br>
                                            <li><i class="fa fa-user"></i> : {{ $user->role ?? 'Role not set' }}</li><br><br>
                                            <!-- Role -->
                                        </ul>

                                    </div>
                                    <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-lg" 
                                       style="position: absolute; bottom: 20px; right: 20px; background-color:#15283c; color:white">
                                       Edit Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection