@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('admin/css/styles.css')}}">



<section class="my-5">
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Admin"
                                    class="rounded-circle p-1 bg-warning" width="110">
                                <div class="mt-3">
                                    <h4>{{ $user['first_name'] }} {{ $user['last_name'] }}</h4>
                                    <p class="text-dark mb-1">+91 {{ $user['mobile'] }}</p>
                                    <p class="text-muted font-size-sm">{{ $user['email'] }}</p>
                                </div>
                            </div>
                            <div class="list-group list-group-flush text-center mt-4">
                                <a href="#" class="list-group-item list-group-item-action border-0 "
                                    onclick="showProfileDetails()">
                                    Profile Informaton
                                </a>
                                <a href="#" class="list-group-item list-group-item-action border-0"
                                    onclick="showOrderDetails()">Orders</a>

                                <a href="#" class="list-group-item list-group-item-action border-0 active"
                                    onclick="showAddressBook()">
                                    Change Password
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="list-group-item list-group-item-action border-0">Logout</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div id="profileDetails" class="card" style="display: none;">
                        <div class="card-body">
                            <div class="profile-info">
                                <h5>Profile Information</h5>
                                <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                                <p><strong>Email Address:</strong> {{ $user->email }}</p>
                                <p><strong>Contact:</strong> {{ $user->mobile }}</p>
                                <p><strong>Age:</strong> {{ $user->age }}</p>
                                <p><strong>Gender:</strong> {{ $user->gender }}</p>
                                <button class="btn btn-primary mt-3" onclick="openEditProfileModal()">Edit
                                    Profile</button>
                            </div>

                        </div>
                        <!-- Modal for editing profile -->
                        <div id="editProfileModal" class="modal" style="display: none;">
                            <div class="modal-content">
                                <span class="close" onclick="closeEditProfileModal()">&times;</span>
                                <h2>Edit Profile</h2>
                                <form id="editProfileForm" action="{{ route('user.profile.edit') }}" method="POST">
                                    @csrf
                                    <div class="col-12 d-flex flex-column inner_flex_div">
                                        <label for="first_name">First Name:</label>
                                        <input class="form-control" type="text" name="first_name" id="first_name"
                                            value="{{ $user->first_name }}"><br>
                                    </div>
                                    <div class="col-12 d-flex flex-column inner_flex_div">
                                        <label for="last_name">Last Name:</label>
                                        <input class="form-control" type="text" name="last_name" id="last_name"
                                            value="{{ $user->last_name }}"><br>
                                    </div>
                                    <div class="col-12 d-flex flex-column inner_flex_div">
                                        <label for="email">Email:</label>
                                        <input class="form-control" type="email" name="email" id="email"
                                            value="{{ $user->email }}"><br>
                                    </div>
                                    <div class="col-12 d-flex flex-column inner_flex_div">
                                        <label for="mobile">Mobile Number:</label>
                                        <input class="form-control" type="tel" id="mobile" name="mobile"
                                            pattern="[0-9]{10}" value="{{ $user->mobile }}"><br>
                                    </div>
                                    <div class="col-12 d-flex flex-column inner_flex_div">
                                        <label for="age">Age:</label>
                                        <input class="form-control" type="number" name="age" id="age"
                                            value="{{ $user->age }}"><br>
                                    </div>
                                    <div class="col-12 d-flex flex-column inner_flex_div">
                                        <label for="gender">Gender:</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>
                                                Female</option>
                                            <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select><br>
                                    </div>
                                    <div class="col-12 d-flex button_div">
                                        <button type="submit" class="btn btn-outline-primary">Save</button>
                                        <button type="button" onclick="closeEditProfileModal()"
                                            class="btn btn-outline-primary">Cancel</button>
                                    </div>
                                    <div id="responseMessage"
                                        style="display:none; padding: 10px; background-color: #f1f1f1; border: 1px solid #ccc; margin-top: 10px;">
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                    <!-- Order Details View Section -->
                    <div id="orderDetails" class="" style="display: none;">
                        <div class="card mt-4 p-5">
                            <div class="card-body p-0">
                                <h4 class="text-center mb-0">Order Details</h4>
                                <div id="order-details-container">
                                    <table id="orders-table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Order_id</th>
                                                <th>Pname</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <button id="back-to-orders-btn" class="btn btn-primary mt-3" style="float:right;">Back
                                    to Orders</button>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Table Section -->
                    <div id="ordersTable" class="" style="display: none;">
                        <div class="card mt-4">
                            <div class="card-body p-0 table-responsive">
                                <h4 class="p-3 mb-0">Orders</h4>
                                <table id="orders-table" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Order_id</th>
                                            <th>Pname</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Orders will be populated here by AJAX -->
                                    </tbody>
                                </table>
                                <div id="message-container"></div>
                            </div>
                        </div>
                    </div>




                    <div id="addressBook" class="card" style="display: none;">
                        <div class="card-body">
                            <h5>Change Password</h5>
                            <button class="btn btn-primary mt-3 change" onclick="showAddAddressModal()">Change
                                Password</button>

                            <div id="addressList">

                            </div>
                        </div>
                    </div>

                    <div id="addAddressModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeAddAddressModal()">&times;</span>
                            <h2 class="mb-5">Change Password</h2>
                            <form id="addAddressForm" onsubmit="saveAddress(event)">
                                <div class="row">
                                    <div class="col-12 d-flex flex-column inner_flex_div">
                                        <label for="current_password">Current Password:</label>
                                        <input class="form-control" type="password" id="current_password"><br>
                                    </div>
                                    <div class="col-12 d-flex flex-column inner_flex_div">
                                        <label for="new_password">New Password:</label>
                                        <input class="form-control" type="password" id="new_password"><br>
                                    </div>
                                    <div class="col-12 d-flex flex-column inner_flex_div mt-3">
                                        <label for="confirm_password">Confirm Password:</label>
                                        <input class="form-control" type="password" id="confirm_password"><br>
                                    </div>
                                </div>

                                <div class="col-12 d-flex button_div">
                                    <button type="submit" class="btn btn-outline-primary">Save</button>
                                    <button type="button" onclick="closeAddAddressModal()"
                                        class="btn btn-outline-primary">Cancel</button>
                                </div>
                                <br>
                                <div id="responseMessage1"
                                    style="display:none; padding: 10px; background-color: #f1f1f1; border: 1px solid #ccc; margin-top: 10px;">
                                </div>
                            </form>
                        </div>


                    </div>



                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

<script>

    function saveAddress(event) {
        event.preventDefault();

        var currentPassword = $('#current_password').val();
        var newPassword = $('#new_password').val();
        var confirmPassword = $('#confirm_password').val();

        if (newPassword !== confirmPassword) {
            alert("New password and confirm password do not match!");
            return;
        }

        $.ajax({
            url: '{{ route('change.password') }}', // Use Laravel route helper to generate URL
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Include CSRF token for security
                current_password: currentPassword,
                new_password: newPassword,
                new_password_confirmation: confirmPassword
            },
            success: function (response) {
                var data = response;

                if (data.status === 'success') {
                    $('#responseMessage1').text(data.message).show().css('background-color', 'green').css('color', 'white');
                    setTimeout(function () {
                        window.location.href = '{{ route('user.profile') }}';
                    }, 1000);
                } else {
                    $('#responseMessage1').text(data.message).show().css('background-color', 'red').css('color', 'white');
                }
            },
            error: function (xhr, status, error) {
                $('#responseMessage1').text("An error occurred while changing the password. Please try again.")
                    .show().css('background-color', 'red').css('color', 'white');
            }
        });
    }

    function showAddAddressModal() {
        const modal = document.getElementById('addAddressModal');
        modal.style.display = 'block';
        isFormVisible = true;
    }

    function closeAddAddressModal() {
        const modal = document.getElementById('addAddressModal');
        modal.style.display = 'none';
        isFormVisible = false;
    }

    function showProfileDetails() {
        hideAllSections();
        document.getElementById('profileDetails').style.display = 'block';
        setActiveLink(0);
    }

    function showOrderDetails() {
        console.log("Showing Order Details");
        hideAllSections();
        document.getElementById('ordersTable').style.display = 'block';
        setActiveLink(1);




        $.ajax({
            url: '/user/orders',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const tbody = $('#orders-table tbody');
                tbody.empty(); // Clear existing rows
                if (data.orders && data.orders.length > 0) {
                    data.orders.forEach(function (order) {
                        if (order.order_items && order.order_items.length > 0) {
                            order.order_items.forEach(function (item) {
                                var row = `
                        <tr>
                        <td>${order.id || "N/A"}</td>
                            <td>${item.product?.name || "N/A"}</td>
                            <td>${item.product?.price || "N/A"}</td>
                            <td>${item.quantity || 0}</td>
                           <td>${(item.product?.price || 0) * (item.quantity || 0)}</td>
                            
                        </tr>`;
                                tbody.append(row);
                            });
                        } else {
                            var row = `
                    <tr>
                        <td colspan="5">No items in this order.</td>
                    </tr>`;
                            tbody.append(row);
                        }
                    });
                } else {
                    tbody.html('<tr><td colspan="5">No orders found.</td></tr>');
                }
            },
            error: function () {
                const tbody = $('#orders-table tbody');
                tbody.html('<tr><td colspan="5">Error fetching orders.</td></tr>');
            }
        });

    }



    function showAddressBook() {
        hideAllSections();
        document.getElementById('addressBook').style.display = 'block';
        setActiveLink(2);
    }

    function hideAllSections() {
        document.getElementById('ordersTable').style.display = 'none';
        document.getElementById('profileDetails').style.display = 'none';
        document.getElementById('addressBook').style.display = 'none';
    }

    function setActiveLink(index) {
        document.querySelector('.list-group-item.active').classList.remove('active');
        document.querySelectorAll('.list-group-item')[index].classList.add('active');
    }
    function openEditProfileModal() {
        document.getElementById('editProfileModal').style.display = 'block';
    }

    function closeEditProfileModal() {
        document.getElementById('editProfileModal').style.display = 'none';
    }

    window.onclick = function (event) {
        var modal = document.getElementById('editProfileModal');
        if (event.target === modal) {
            closeEditProfileModal();
        }
    }
    showProfileDetails();
</script>

@endsection