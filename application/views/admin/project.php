<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">New Project Information</h4>
                    <form id="projectForm" class="forms-sample">
                        <input type="hidden" id="projectId" name="project_id">
                        <div class="form-group">
                            <label for="clientSelect">Select client name</label>
                            <select class="form-control" id="clientSelect" name="client_id" required>
                                <option disabled selected>Choose client</option>
                                <!-- Client options will be populated here by AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="projectName">Project name</label>
                            <input type="text" class="form-control" id="projectName" name="project_name" placeholder="Enter Project name" required>
                        </div>
                        <div class="form-group">
                            <label for="websiteLink">Website link</label>
                            <input type="url" class="form-control" id="websiteLink" name="website_link" placeholder="Enter Website link" required>
                        </div>
                        <button type="submit" id="submitButton" class="btn btn-primary me-2">Submit</button>
                        <button type="reset" class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Projects Data Table -->
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Projects Data Table</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client Name</th>
                                    <th>Project Name</th>
                                    <th>Website Link</th>
                                    <th>Added on</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="projectsTableBody">
                                <!-- Project rows will be populated here by AJAX -->
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
        loadClients();
        loadProjects();

        // Handle form submission (Create/Update Project)
        $('#projectForm').on('submit', function(event) {
            event.preventDefault();
            let url = $('#projectId').val() ? '<?php echo base_url('Project/update_project'); ?>' : '<?php echo base_url('Project/submit_project'); ?>';

            $.ajax({
                url: url,
                method: 'POST',
                data: $('#projectForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    $('#projectForm')[0].reset();
                    $('#projectId').val('');
                    $('#submitButton').text('Submit');
                    loadProjects();
                }
            });
        });

        // Load client options dynamically via AJAX
        function loadClients() {
            $.ajax({
                url: '<?php echo base_url('Project/get_clients_ajax'); ?>',
                method: 'GET',
                dataType: 'json',
                success: function(clients) {
                    $('#clientSelect').empty().append('<option disabled selected>Choose client</option>');
                    $.each(clients, function(index, client) {
                        $('#clientSelect').append('<option value="' + client.id + '">' + client.client_name + '</option>');
                    });
                }
            });
        }

        // Load all projects into the table
        function loadProjects() {
            $.ajax({
                url: '<?php echo base_url('Project/get_projects'); ?>',
                method: 'GET',
                dataType: 'json',
                success: function(projects) {
                    let tableBody = '';
                    $.each(projects, function(index, project) {
                        tableBody += `
                            <tr>
                                <td>${project.project_id}</td>
                                <td>${project.client_name}</td>
                                <td>${project.project_name}</td>
                                <td><a href="${project.website_link}" target="_blank">${project.website_link}</a></td>
                                <td>${project.created_at}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="editProject(${project.project_id})">EDIT</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteProject(${project.project_id})">DELETE</button>
                                    <a href="<?php echo base_url('admin/offpage/' . '${project.project_id}'); ?>" class="btn btn-info">Fill Data</a>
                                </td>
                            </tr>`;
                    });
                    $('#projectsTableBody').html(tableBody);
                }
            });
        }

        // Edit a project
        window.editProject = function(project_id) {
            $.ajax({
                url: '<?php echo base_url('Project/get_project'); ?>/' + project_id,
                method: 'GET',
                dataType: 'json',
                success: function(project) {
                    $('#projectId').val(project.project_id);
                    $('#projectName').val(project.project_name);
                    $('#websiteLink').val(project.website_link);
                    $('#clientSelect').val(project.client_name);
                    $('#submitButton').text('Update');
                }
            });
        }

        // Delete a project
        window.deleteProject = function(project_id) {
            if (confirm("Do you really want to delete this project?")) {
                $.ajax({
                    url: '<?php echo base_url('Project/delete_project'); ?>/' + project_id,
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        alert(response.message);
                        loadProjects();
                    }
                });
            }
        }
    });
</script>
