@extends('admin-layout.app')
@section('title', 'dashboard')
@section('content')

<style>
    .contact_card {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .contact_inner {
        display: flex;
        justify-content: space-between;
    }

    .contact_inner .left {
        flex: 1;
        padding-right: 10px;
    }

    .contact_inner .right {
        flex: 0 0 150px;
    }

    .bottom_list {
        text-align: center;
        margin-top: 10px;
    }

    .right_button .btn {
        background-color: #007bff;
        color: #fff;
    }
</style>

<div class="container-fluid">

    <!-- row -->
    <div class="row column1 mt-5">
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0">
                        <h2>User Information</h2>
                    </div>
                </div>
                <div class="full price_table padding_infor_info">
                    <div class="row">
                        <!-- column contact -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile_details margin_bottom_30">
                            <div class="contact_blog">
                                <h4 class="brief">User Info</h4>
                                <div class="contact_inner">
                                    <div class="left">
                                        <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                                        <p><strong>Email:</strong> {{ $user->email }}</p>
                                        <p><strong>Age:</strong> {{ $user->age }}</p>
                                        <p><strong>Gender:</strong> {{ $user->gender }}</p>
                                        <p><strong>Mobile:</strong> {{ $user->mobile }}</p>
                                    </div>
                                    <div class="right">
                                        <div class="profile_contacts">
                                            @if ($user->profile_picture)
                                                <img class="img-responsive"
                                                    src="{{ asset('storage/' . $user->profile_picture) }}"
                                                    alt="Profile Picture" width="150" height="150" />
                                            @else
                                                <img class="img-responsive" src="{{ asset('images/default-profile.png') }}"
                                                    alt="Default Profile" width="150" height="150" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom_list">
                                    <div class="right_button" >
                                        <a href="{{ route('users.index') }}" class="btn  btn-xs" style="background-color:#15283c">
                                            <i class="fa fa-user"></i> Back To UserList
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end column contact blog -->

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>
<!-- footer -->

</div>

@endsection