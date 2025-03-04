<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Information</h4>
                    <form id="userForm" class="forms-sample">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" placeholder="Enter First Name">
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="email">E-mail</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter Email">
                                </div>

                                <div class="col-md-6">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Enter Username">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter Password">
                                </div>

                                <div class="col-md-6">
                                    <label for="role">Role</label>
                                    <select class="form-control" id="role">
                                        <option selected disabled>Select Role</option>
                                        <option>Admin</option>
                                        <option>SEO team member</option>
                                        <option>Manager</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2 mt-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Projects Data Table</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                    <th>E-mail</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="UsersTableBody">
                                <!-- User rows will be populated here by AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Fetch users when the page loads
        fetchUsers();

        // Submit form to add a new user
        $('#userForm').submit(function (e) {
            e.preventDefault();

            var password = $('#password').val();
            if (password.trim() === '') {
                alert('Password is required');
                return;
            }

            var data = {
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                email: $('#email').val(),
                username: $('#username').val(),
                password: password,
                role: $('#role').val(),
            };

            $.ajax({
                url: '<?php echo base_url("Manage_users/add_user"); ?>',
                type: 'POST',
                data: data,
                success: function (response) {
                    alert('User added successfully!');
                    $('#userForm')[0].reset();
                    fetchUsers(); // Refresh the table with updated user list
                },
                error: function (xhr, status, error) {
                    alert('Error: ' + error);
                },
            });
        });

        // Fetch users from the server
        function fetchUsers() {
            $.ajax({
                url: '<?php echo base_url("Manage_users/get_usersdata"); ?>',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    $('#UsersTableBody').empty();
                    if (response.data && response.data.length > 0) {
                        $.each(response.data, function (index, user) {
                            var row = `
                                <tr>
                                    <td>${index + 1}.</td>
                                    <td>${user.id}</td>
                                    <td>${user.first_name}</td>
                                    <td>${user.last_name}</td>
                                    <td>${user.username}</td>
                                    <td>${user.email}</td>
                                    <td>${user.password}</td>
                                    <td>${user.role}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-success btn-icon-text" onclick="editUser(${user.id})">
                                            <i class="mdi mdi-marker btn-icon-prepend"></i> EDIT
                                        </button>
                                       <button type="button" class="btn btn-sm btn-outline-danger btn-icon-text" onclick="deleteUser(${user.id})">
                                             <i class="mdi mdi-account-off btn-icon-prepend"></i> DELETE
                                        </button>

                                    </td>
                                </tr>`;
                            $('#UsersTableBody').append(row);
                        });
                    } else {
                        $('#UsersTableBody').append('<tr><td colspan="9">No users found.</td></tr>');
                    }
                },
                error: function (xhr, status, error) {
                    alert('Error fetching users: ' + error);
                },
            });
        }

        // Delete user function
        window.deleteUser = function (id) {
            if (confirm("Do you really want to delete this client?")) {
                $.ajax({
                    url: '<?php echo base_url('Manage_users/delete_user'); ?>/' + id,
                    method: 'POST',
                    dataType: 'json', // Ensure response is parsed as JSON
                    success: function (response) {
                        if (response.status === 'success') {
                            alert('User deleted successfully!');
                            fetchUsers(); // Refresh the table after successful deletion
                        } else {
                            console.error(response.message); // Log any error message from the server
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error deleting client:', error);
                    }
                });
            }
        };
    });
</script>

