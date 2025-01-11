<nav id="sidebar">
    <div class="sidebar_blog_1">

        <div class="sidebar_user_info">
            <div class="icon_setting"></div>
            <div class="user_profle_side">
            <a href="" class="text-decoration-none">
               <h1 class=" display-5 font-weight-semi-bold " style="color:white;margin-left:10px;margin-top:10px">
                  <span class=" font-weight-bold border px-3 mr-1" style="color:white;">E</span>Shopper
               </h1>
            </a>
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
                <li><a href="{{route('orders.create')}}">> <span>Add Order</span></a></li>
                    <li>
                        <a href="{{route('orders.index')}}">> <span>All Order</span></a>
                    </li>

                </ul>
            </li>
            <li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out purple_color2"></i> <span>Logout</span></a></li>
      
        </ul>
    </div>
</nav>