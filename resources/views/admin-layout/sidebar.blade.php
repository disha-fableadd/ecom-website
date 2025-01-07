<nav id="sidebar">
    <div class="sidebar_blog_1">

        <div class="sidebar_user_info">
            <div class="icon_setting"></div>
            <div class="user_profle_side">
                <div class="user_img"><img class="img-responsive"
                        src="{{ asset('storage/' . $user->profile_picture) }}" alt="#" /></div>
                <div class="user_info">
                    <h6>{{ $user->first_name }} {{ $user->last_name }}</h6>
                    <p class="text-light"> <small>Admin Dashboard</small> </p>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar_blog_2">

        <ul class="list-unstyled components">
            <li class="active">
                <a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a>

            </li>

            <li>
                <a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                        class="fa fa-diamond purple_color"></i> <span>Customer</span></a>
                <ul class="collapse list-unstyled" id="element">
                    <li><a href="{{route('users.create')}}">> <span>Add Customer</span></a></li>
                    <li><a href="{{route('users.index')}}">> <span>All Customer</span></a></li>

                </ul>
            </li>

            <li>
                <a href="#apps" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                        class="fa fa-object-group blue2_color"></i> <span>Product</span></a>
                <ul class="collapse list-unstyled" id="apps">
                    <li><a href="{{route('products.create')}}">> <span>Add Product</span></a></li>
                    <li><a href="{{route('products.index')}}">> <span>All Product</span></a></li>

                </ul>
            </li>
            <li class="active">
                <a href="#additional_page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                        class="fa fa-clone yellow_color"></i> <span> Orders</span></a>
                <ul class="collapse list-unstyled" id="additional_page">
                   
                    <li>
                        <a href="{{route('orders.index')}}">> <span>All Order</span></a>
                    </li>

                </ul>
            </li>
            <li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out purple_color2"></i> <span>Logout</span></a></li>
      
        </ul>
    </div>
</nav>