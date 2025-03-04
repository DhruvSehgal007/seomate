<div class="content-wrapper">
    <div class="row">
        <!-- Existing form for new project information -->
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">New Project Information</h4>
                    <form id="projectForm" class="forms-sample">
                        <input type="hidden" id="projectId" name="project_id">
                        <div class="form-group">
                            <label for="companySelect">Select company name</label>
                            <select class="form-control" id="companySelect" name="company_id" required>
                                <option disabled selected>Choose Company</option>
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

        <!-- Off-page categories form -->
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Off-Page Categories</h4>
                    <p class="card-description">Fill numbers for each category and submit</p>
                    
                    <div id="offpageAlert"></div>
                    
                    <!-- New form for offpage categories -->
                    <form id="offpageForm">
                        <div class="table-responsive pt-3">

                        <div class="form-group">
                            <label for="projectSelect">Select Project name</label>
                            <select class="form-control" id="projectSelect" name="project_id" required>
                                <option disabled selected>Choose project</option>
                            </select>
                        </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>OFF page Categories</th>
                                        <th>Progress</th>
                                    </tr>
                                </thead>
                                <tbody id="offpageCategoriesBody">
                                    <!-- Off-page categories will be inserted here by AJAX -->
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Submit Categories</button>
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
                                    <th>Company Name</th>
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
    loadoffprojects();
    loadProjects();
    loadOffpageCategories();

    // Handle form submission (Offpage categories form)
    $('#offpageForm').on('submit', function(e) {
        e.preventDefault();

        // Get the selected project_id and project_name from the dropdown
        let project_id = $('#projectSelect').val();
        let project_name = $('#projectSelect option:selected').text(); 
        // Since option text is project_name, we can use .text(), or if you stored in data attribute, use data('project-name')

        // Convert form data to array
        let formDataArray = $(this).serializeArray();

        // Add project_id and project_name to formDataArray
        formDataArray.push({ name: 'project_id', value: project_id });
        formDataArray.push({ name: 'project_name', value: project_name });

        $.ajax({
            url: '<?php echo base_url("Project/add_offpage_numbers"); ?>', // Controller method to insert data
            method: 'POST',
            data: $.param(formDataArray), // Convert formData array to query string
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    $('#offpageAlert').html('<div class="alert alert-success">' + response.message + '</div>');
                    $('#offpageForm')[0].reset();
                    loadOffpageCategories(); // Reload categories if needed
                } else {
                    $('#offpageAlert').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function() {
                $('#offpageAlert').html('<div class="alert alert-danger">An error occurred.</div>');
            }
        });
    });

    function loadClients() {
        $.ajax({
            url: '<?php echo base_url('Project/get_clients_ajax'); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(clients) {
                $('#companySelect').empty().append('<option disabled selected>Choose company</option>');
                $.each(clients, function(index, client) {
                    $('#companySelect').append('<option value="' + client.id + '">' + client.company_name + '</option>');
                });
            }
        });
    }

    function loadoffprojects() {
        $.ajax({
            url: '<?php echo base_url('Project/get_projects_ajax'); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(projects) {
                $('#projectSelect').empty().append('<option disabled selected>Choose project</option>');
                $.each(projects, function(index, project) {
                    // project.project_id and project.project_name exist
                    $('#projectSelect').append('<option value="' + project.project_id + '">' + project.project_name + '</option>');
                });
            }
        });
    }

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
                            <td>${project.company_name}</td>
                            <td>${project.project_name}</td>
                            <td><a href="${project.website_link}" target="_blank">${project.website_link}</a></td>
                            <td>${project.created_at}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="editProject(${project.project_id})">EDIT</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteProject(${project.project_id})">DELETE</button>
                                <a href="<?php echo base_url('admin/offpage/'); ?>${project.project_id}" class="btn btn-info">Fill Data</a>
                            </td>
                        </tr>`;
                });
                $('#projectsTableBody').html(tableBody);
            }
        });
    }

    window.editProject = function(project_id) {
        $.ajax({
            url: '<?php echo base_url('Project/get_project'); ?>/' + project_id,
            method: 'GET',
            dataType: 'json',
            success: function(project) {
                $('#projectId').val(project.project_id);
                $('#projectName').val(project.project_name);
                $('#websiteLink').val(project.website_link);
                $('#companySelect').val(project.company_name);
                $('#submitButton').text('Update');
            }
        });
    }

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

    function loadOffpageCategories() {
        $.ajax({
            url: '<?php echo base_url("Project/get_offpage_categories"); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let categories = response.categories;
                let tbody = $('#offpageCategoriesBody');
                tbody.empty(); // Clear existing rows

                if (categories.length > 0) {
                    categories.forEach(function(category, index) {
                        tbody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${category.off_Category_name}</td>
                                <td>
                                    <input type="hidden" name="category_id[]" value="${category.category_id}">
                                    <input type="number" name="numbers[]" class="form-control" placeholder="Enter Number" required min="4" max="50">
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.append('<tr><td colspan="3" class="text-center">No categories found</td></tr>');
                }
            },
            error: function() {
                $('#offpageCategoriesBody').html('<tr><td colspan="3" class="text-center">Failed to load categories.</td></tr>');
            }
        });
    }

});
</script>


