<div class="topbar">
   <nav class="navbar navbar-expand-lg navbar-light ">
      <div class="full">
         <button type="button" id="sidebarCollapse" class="sidebar_toggle text-dark"><i class="fa fa-bars text-dark"></i></button>
         <div class="logo_section">
            <a href="" class="text-decoration-none">
               <h1 class=" display-5 font-weight-semi-bold " style="color:#D19C97;margin-left:10px;margin-top:10px">
                  <span class=" font-weight-bold border px-3 mr-1" style="color:#D19C97;">E</span>Shopper
               </h1>
            </a>
         </div>
         <div class="right_topbar">
            <div class="icon_info">
               <ul class="user_profile_dd">
                  <li>
                     <a class="dropdown-toggle" href="{{route('admin.profile')}}"><img class="img-responsive rounded-circle"
                           src="{{ asset('storage/' . $user->profile_picture) }}" alt="#" /><span class="name_user " style="color:#D19C97;">{{ $user->first_name }} {{ $user->last_name }}</span></a>

                  </li>
               </ul>
            </div>
         </div>
      </div>
   </nav>
</div>
