<div class="content-wrapper">
    <div class="row">
	 <?php 
	if($projectid == null){
		$projectid = '';
	}
	
	?>
        <!-- Dropdown to select a project -->
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Select Project</h4>
                    <div class="form-group">
                        <label for="projectDropdown">Select Project</label>
                        <div style="display: flex; align-items: center;">
                            <select class="form-control" id="projectDropdownn" style="margin-right: 10px;">
                                <option  selected>Choose a project</option>
                                <?php foreach ($projects as $project): 
								$project_id = $project['project_id'];
								if($projectid == $project_id){?>
									 <option value="<?php echo $project['project_id']; ?>"  selected ><?php echo $project['project_name']; ?>
                                    </option>
								<?php
								}else{?>
									<option value="<?php echo $project['project_id']; ?>" ><?php echo $project['project_name']; ?>
                                    </option>
								<?php
								}
								?>    
                                <?php endforeach; ?>
                            </select>
                            <button id="viewDataButton" class="btn btn-primary">View Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display selected project name -->
        <h3>Project Name: <span id="projectName"><?php echo $selected_project['project_name'] ?? '______________'; ?></span></h3>

    </div>

     <!-- SEO Navigation Bar -->
     <div class="seo-bar">
   
    <div class="seo-item on-page">
        <a href="<?php echo base_url("admin/onpage/$projectid");?>" id="onpageLink">ON PAGE OPTIMIZATION</a>
    </div>
    <div class="seo-item off-page active">
        <a href="<?php echo base_url("admin/offpage/$projectid");?>" id="offpageLink">OFF PAGE OPTIMIZATION</a>
    </div>
    <div class="seo-item keywords">
        <a href="<?php echo base_url("admin/keywords/$projectid");?>" id="keywordsLink">KEYWORDS</a>
    </div>
    <div class="seo-item ranking">
        <a href="<?php echo base_url("admin/google_ranking/$projectid");?>" id="rankingLink">RANKING ON GOOGLE</a>
    </div>
    <div class="seo-item empty" style="background-color: #145874;"></div>
</div>



<!-- Numberssss -->
<section class="data_number_section">
    <div class="row data_number_row" id="dataNumberRow">
        <!-- Dynamic columns will be appended here based on selected project -->
    </div>
</section>


<!-- /Numberssss  -->




    <!-- Form to Add or Update Off Page Data -->
    <div class="row offdatarow">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Off Page Information</h4>
                    <form id="offpageForm" class="forms-sample">
                        <input type="hidden" id="entryId" name="id" value="">
                        <input type="hidden" id="project_id" name="project_id" value="<?php echo $selected_project['project_id'] ?? ''; ?>">

                        <!-- Static Off Page Category -->
                        <div class="form-group">
                            <label for="offPageCategory">Off Page Category</label>
                            <select class="form-control" id="offPageCategory" name="off_page_category" required>
                                <option disabled selected>Choose category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['category_id']; ?>">
                                        <?php echo $category['off_Category_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Section for dynamically added Off Page Links -->
                        <div id="dynamicLinks">
                            <div class="form-group">
                                <label for="offPageLink">Off Page Link</label>
                                <input type="url" class="form-control" name="off_page_link[]" placeholder="Enter link" required>
                            </div>
                        </div>

                        <!-- Add More Button -->
                        <button type="button" id="addMoreButton" class="btn btn-secondary">Add More</button>

                        <!-- Submit and Update Buttons -->
                        <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                        <button type="button" id="updateButton" class="btn btn-warning" style="display: none;">Update</button>
                    </form>

                </div>
            </div>
        </div>

        <!-- Table to Display Off Page Data -->
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Off Page Data</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered newbt">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Project Name</th>
                                    <th>Off Category</th>
                                    <th>Off Page Link</th>
                                    <th>Added on</th>
                                    <th>Updated on</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="offPageTableBody">
                                <tr><td colspan="7">No data available for this project.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    loadClients();
    loadoffprojects();
    loadProjects();
    loadOffpageCategories();

    // Determine projectId from URL if available
    const currentUrl = window.location.href;
    const projectIdMatch = currentUrl.match(/\/(\d+)$/);
    const projectId = projectIdMatch ? projectIdMatch[1] : null;

    if (projectId) {
        updateNavigationLinks(projectId);
        $('#projectDropdownn option[value="' + projectId + '"]').attr('selected', 'selected');
        $('#projectDropdownn').val(projectId);
        fetchOffPageData(projectId); 
        loadOffpageNumbers(projectId);
    }


    // Add More Button Functionality
    $('#addMoreButton').click(function () {
        $('#dynamicLinks').append(`
            <div class="form-group">
                <label for="offPageLink">Off Page Link</label>
                <input type="url" class="form-control" name="off_page_link[]" placeholder="Enter link" required>
            </div>
        `);
    });



    $('#projectDropdownn').change(function () {
        const selectedProjectId = $(this).val();
        if (selectedProjectId) {
            const newUrl = '<?php echo base_url("admin/offpage"); ?>/' + selectedProjectId;
            window.location.href = newUrl;
        }
    });

    function updateNavigationLinks(projectId) {
        const adminBaseUrl = '<?php echo base_url("admin"); ?>';
        $('#offpageLink').attr('href', `${adminBaseUrl}/offpage/${projectId}`);
        $('#onpageLink').attr('href', `${adminBaseUrl}/onpage/${projectId}`);
        $('#keywordsLink').attr('href', `${adminBaseUrl}/keywords/${projectId}`);
        $('#rankingLink').attr('href', `${adminBaseUrl}/google_ranking/${projectId}`);
    }

    // Fetch data for the selected project (off page data)
    function fetchOffPageData(projectId) {
    $.ajax({
        url: '<?php echo base_url("Offpage_data/get_offpage_data"); ?>/' + projectId,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            const data = response.data || [];
            const tableBody = $('#offPageTableBody');
            tableBody.empty();

            if (data.length > 0) {
                let rows = '';
                data.forEach((item, index) => {
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.project_name}</td>
                            <td>${item.off_Category_name}</td>
                            <td><a href="${item.off_page_link}" target="_blank">${item.off_page_link}</a></td>
                            <td>${item.created_at}</td>
                            <td>${item.updated_at}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="editOffPage(${item.id})">EDIT</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteOffPage(${item.id})">DELETE</button>
                            </td>
                        </tr>
                    `;
                });
                tableBody.html(rows);
            } else {
                tableBody.html('<tr><td colspan="7">No data available for this project.</td></tr>');
            }
        },
        error: function () {
            alert('Failed to fetch data.');
        },
    });
}

    // Handle form submission (projectForm)
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
                tbody.empty();

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

    // Load Offpage Numbers by project to display in .data_number_section
    function loadOffpageNumbers(project_id) {
    $.ajax({
        url: '<?php echo base_url("Offpage_data/show_project_offpage_numbers"); ?>/' + project_id,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            let data = response.data;
            let dataNumberRow = $('#dataNumberRow');
            dataNumberRow.empty();

            if (data.length > 0) {
                // All categories are returned with their total_numbers (user set or default) and link_count
                data.forEach(function(item, index) {
                    dataNumberRow.append(`
                        <div class="col-md-1 cols_div">
                            <div class="listing_div_number">
                                <h3><span class="number_from_db">${item.link_count}</span>/<span class="total numbers">${item.total_numbers}</span></h3>
                            </div>
                            <div class="listing_div_text">
                                <p>${item.off_Category_name}</p>
                            </div>    
                        </div>
                    `);
                });
            } else {
                // If no categories at all (which would be odd), show a message
                dataNumberRow.append('<div class="col-12"><p>No categories available at all.</p></div>');
            }
        },
        error: function() {
            $('#dataNumberRow').html('<div class="col-12"><p>Failed to load data.</p></div>');
        }
    });
}






$('#offpageForm').submit(function (e) {
    e.preventDefault();
    const projectId = $('#project_id').val();
    if (!projectId) {
        alert('Please select a project.');
        return;
    }

    $.ajax({
        url: '<?php echo base_url("Offpage_data/add_offpage_data"); ?>',
        method: 'POST',
        data: $(this).serialize(), // Serialize the form data, including the array
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert('Data inserted successfully.');
                fetchOffPageData(projectId); 
                $('#offpageForm')[0].reset(); 
                $('#dynamicLinks').html(''); // Clear dynamically added fields
            } else {
                alert(response.message || 'Failed to insert data.');
            }
        },
        error: function () {
            alert('Failed to submit data.');
        },
    });
});



window.editOffPage = function (id) {
    $.ajax({
        url: '<?php echo base_url("Offpage_data/get_offpage_data_by_id"); ?>/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                alert(data.error);
                return;
            }

            // Populate form fields with fetched data
            $('#entryId').val(data.id); // ID of the entry
            $('#offPageCategory').val(data.off_page_category); // Select the correct category
            $('#dynamicLinks').html(`
                <div class="form-group">
                    <label for="offPageLink">Off Page Link</label>
                    <input type="url" class="form-control" name="off_page_link[]" value="${data.off_page_link}" placeholder="Enter link" required>
                </div>
            `);

            // Switch to update mode
            $('#submitButton').hide();
            $('#updateButton').show();
        },
        error: function () {
            alert('Failed to fetch data for editing.');
        },
    });
};


$('#updateButton').click(function () {
    const entryId = $('#entryId').val();
    const projectId = $('#project_id').val();

    if (!entryId) {
        alert('No data selected for update.');
        return;
    }

    const formData = $('#offpageForm').serializeArray();
    console.log("Serialized Data: ", formData);

    $.ajax({
        url: '<?php echo base_url("Offpage_data/update_offpage_data"); ?>',
        method: 'POST',
        data: formData, // Serialize form data for a single link
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert('Data updated successfully.');
                fetchOffPageData(projectId);
                resetForm(); 
            } else {
                alert(response.message || 'Failed to update data.');
            }
        },
        error: function () {
            alert('Failed to update data.');
        },
    });
});

    window.deleteOffPage = function (id) {
        if (confirm('Are you sure you want to delete this data?')) {
            $.ajax({
                url: '<?php echo base_url("Offpage_data/delete_offpage_data"); ?>/' + id,
                method: 'POST',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        fetchOffPageData($('#project_id').val()); 
                        alert('Data deleted successfully.');
                    } else {
                        alert('Failed to delete data.');
                    }
                },
                error: function () {
                    alert('Failed to delete data.'); 
                },
            });
        }
    };

    function resetForm() {
        $('#offpageForm')[0].reset(); 
        $('#entryId').val('');
        $('#submitButton').show();
        $('#updateButton').hide();
    }
});
</script>