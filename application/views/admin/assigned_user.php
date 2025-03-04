<div class="content-wrapper">
    <div class="row">
    <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Assigned Projects</h4>
                 
                  <form class="forms-sample" id="assigned_data_form" method="post">
    <div class="form-group">
        <label for="userSelect">Select User name</label>
        <select class="form-control" id="userSelect" name="username" required>
            <option disabled selected>Choose user</option>
        </select>
    </div>
    <div class="form-group">
        <label for="userProjects">Select Project</label>
        <select class="form-control" id="userProjects" name="project_names" required>
            <option disabled selected>Choose Project</option>
        </select>
    </div>
    <div class="cancelbtndiv">
        <button type="button" id="addMoreBtn" class="btn addtext">Add More +</button>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

                </div>
              </div>
            </div>

            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Users</h4>
                 
                  <div class="table-responsive">
                  <table id="assignedDataTable" class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Project Name</th>
            
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="assignedDataTableBody">
        <!-- Data will be dynamically inserted here -->
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
  $(document).ready(function() {
    loadusers();
    loadProjects();
    fetchAssignedData();

    // Handle form submission
    $('#assigned_data_form').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        var formData = $(this).serialize(); // Serialize form data

        // AJAX request to submit form data
        $.ajax({
            url: '<?php echo base_url('Assigned_user/submit_assigned_data'); ?>',  // Controller function
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Data inserted successfully!');
                    $('#assigned_data_form')[0].reset(); // Reset form fields
                } else {
                    alert('Failed to insert data. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error occurred: ', error);
                alert('An error occurred while inserting data.');
            }
        });
    });

    // Load users options dynamically via AJAX
    function loadusers() {
        $.ajax({
            url: '<?php echo base_url('Assigned_user/get_users'); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(users) {
                $('#userSelect').empty().append('<option disabled selected>Choose User</option>');
                $.each(users, function(index, user) {
                    $('#userSelect').append('<option value="' + user.id + '">' + user.fullname + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading users:', error);
            }
        });
    }

    // Load projects options dynamically via AJAX
    function loadProjects() {
        $.ajax({
            url: '<?php echo base_url('Assigned_user/get_projects'); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(projects) {
                $('#userProjects').empty().append('<option disabled selected>Choose Project</option>');
                $.each(projects, function(index, project) {
                    $('#userProjects').append('<option value="' + project.project_id + '">' + project.project_name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading projects:', error);
            }
        });
    }







    function fetchAssignedData() {
    $.ajax({
        url: '<?php echo base_url('Assigned_user/fetch_assigned_data'); ?>', // Your endpoint for fetching assigned data
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#assignedDataTableBody').empty(); // Clear the existing rows
            if (response && response.length > 0) {
                $.each(response, function(index, data) {
                    var row = `
                        <tr>
                            <td>${index + 1}.</td>
                            <td>${data.username}</td> <!-- Display User Name -->
                            <td>${data.project_names}</td> <!-- Display Project Name -->
                            
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-success btn-icon-text" onclick="editAssignedData(${data.id})">
                                    <i class="mdi mdi-marker btn-icon-prepend"></i> EDIT
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-icon-text" onclick="deleteAssignedData(${data.id})">
                                    <i class="mdi mdi-account-off btn-icon-prepend"></i> DELETE
                                </button>
                            </td>
                        </tr>`;
                    $('#assignedDataTableBody').append(row); // Append new rows to the table
                });
            } else {
                $('#assignedDataTableBody').append('<tr><td colspan="5">No assigned data found.</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching assigned data:', error);
            // alert('An error occurred while loading assigned data.');
        }
    });
}



});

</script>
