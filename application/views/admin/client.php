<div class="content-wrapper">
    <div class="row">
        <!-- New Client Information Form -->
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Client Information</h4>
                    
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success">
                            <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <form class="forms-sample" id="clientForm" method="post">
                        <input type="hidden" name="client_id" id="clientId"> <!-- Hidden input for client ID -->
                        <div class="form-group">
                            <label for="clientName">Client Name</label>
                            <input type="text" name="client_name" class="form-control" id="clientName" placeholder="Enter Client Name" required>
                        </div>
                        <div class="form-group">
                            <label for="clientEmail">Email address</label>
                            <input type="email" name="client_email" class="form-control" id="clientEmail" placeholder="Enter Client Email" required>
                        </div>
                        <div class="form-group">
                            <label for="clientPhone">Client Phone Number</label>
                            <input type="text" name="client_phone" class="form-control" id="clientPhone" placeholder="Phone number" required>
                        </div>
                        <div class="form-group">
                            <label for="industryType">Industry Type</label>
                            <select name="industry_type" class="form-control" id="industryType" required>
                                <option selected disabled>Select Industry</option>
                                <option>E-commerce</option>
                                <option>Hospitality</option>
                                <option>Healthcare</option>
                                <option>Education</option>
                                <option>Finance</option>
                            </select>
                        </div>
                        <button type="submit" id="submitButton" class="btn btn-primary me-2">Submit</button>
                        <button type="reset" class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Clients Data Table -->
        <div class="col-md-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Clients Data Table</h4>
                    <div class="table-responsive">
                        <table class="table" id="clientsTable">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>ID</th>
                                    <th>Client Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Industry Type</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="clientsTableBody">
                                <!-- Data will be populated here -->
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
    fetchClients();

    // Handle form submission for both add and update
    $('#clientForm').on('submit', function(event) {
        event.preventDefault();
        if ($('#clientId').val()) {
            updateClient();
        } else {
            submitForm();
        }    
    });
});

    // Function to fetch and display clients
    function fetchClients() {
    $.ajax({
        url: '<?php echo base_url('Clients/getclients'); ?>',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#clientsTableBody').empty();
            if (response.clients && response.clients.length > 0) {
                $.each(response.clients, function(index, client) {
                    var row = `
                        <tr>
                            <td>${index + 1}.</td>
                            <td>${client.id}</td>
                            <td>${client.client_name}</td>
                            <td>${client.client_email}</td>
                            <td>${client.client_phone}</td>
                            <td>${client.industry_type}</td>
                            <td>${client.created_at}</td>
                            <td>${client.updated_at}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-success btn-icon-text" onclick="editClient(${client.id})">
                                    <i class="mdi mdi-marker btn-icon-prepend"></i> EDIT
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-icon-text" onclick="deleteClient(${client.id})">
                                    <i class="mdi mdi-account-off btn-icon-prepend"></i> DELETE
                                </button>
                            </td>
                        </tr>`;
                    $('#clientsTableBody').append(row);
                });
            } else {
                $('#clientsTableBody').append('<tr><td colspan="9">No clients found.</td></tr>');
            }
        }
    });
}

    // Edit client function
    function editClient(id) {
        $.ajax({
            url: '<?php echo base_url('Clients/get_client'); ?>/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(client) {
                // Populate form with client data
                $('#clientId').val(client.id);
                $('#clientName').val(client.client_name);
                $('#clientEmail').val(client.client_email);
                $('#clientPhone').val(client.client_phone);
                $('#industryType').val(client.industry_type);

                // Change the form button to "Update"
                $('#submitButton').text('Update');
            }
        });
    }

    // Update client function
    function updateClient() {
    var data = $('#clientForm').serialize();

    $.ajax({
        url: '<?php echo base_url('Clients/update_client'); ?>',
        method: 'POST',
        data: data,
        dataType: 'json',  // Ensure jQuery expects a JSON response
        success: function(response) {
            if (response.status === 'success') {
                fetchClients();  // Reload the clients list
                $('#clientForm')[0].reset();  // Reset the form
                $('#clientId').val('');  // Clear hidden client ID
                $('#submitButton').text('Submit');  // Change button text back to Submit
            } else {
                console.error(response.message);  // Log the error message
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating client:', error);
        }
    });
}



function deleteClient(id) {
    if (confirm("Do you really want to delete this client?")) {
        $.ajax({
            url: '<?php echo base_url('Clients/delete_client'); ?>/' + id,
            method: 'POST',
            dataType: 'json', // Ensure response is parsed as JSON
            success: function(response) {
                if (response.status === 'success') {
                    location.reload();  // Refresh the page after successful deletion
                } else {
                    console.error(response.message);  // Log any error message from the server
                }
            },
            error: function(xhr, status, error) {
                console.error('Error deleting client:', error);
            }
        });
    }
}


    // Submit form for adding new client
    function submitForm() {
        var data = $('#clientForm').serialize();

        $.ajax({
            url: '<?php echo base_url('Clients/submit_form'); ?>',
            method: 'POST',
            data: data,
            success: function(response) {
                fetchClients();
                $('#clientForm')[0].reset();
                alert(response.message);
            },
            error: function(xhr, status, error) {
                console.error('Error adding client:', error);
            }
        });
    }
</script>
