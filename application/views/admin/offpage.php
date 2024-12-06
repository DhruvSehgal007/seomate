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
    <div class="seo-item off-page active">
        <a href="<?php echo base_url("admin/offpage/$projectid");?>" id="offpageLink">OFF PAGE OPTIMIZATION</a>
    </div>
    <div class="seo-item on-page">
        <a href="<?php echo base_url("admin/onpage/$projectid");?>" id="onpageLink">ON PAGE OPTIMIZATION</a>
    </div>
    <div class="seo-item keywords">
        <a href="<?php echo base_url("admin/keywords/$projectid");?>" id="keywordsLink">KEYWORDS</a>
    </div>
    <div class="seo-item ranking">
        <a href="<?php echo base_url("admin/google_ranking/$projectid");?>" id="rankingLink">RANKING ON GOOGLE</a>
    </div>
    <div class="seo-item empty" style="background-color: #145874;"></div>
</div>


    <!-- Form to Add or Update Off Page Data -->
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Off Page Information</h4>
                    <form id="offpageForm" class="forms-sample">
                    <input type="hidden" id="entryId" name="id" value="">

    <input type="hidden" id="project_id" name="project_id" value="<?php echo $selected_project['project_id'] ?? ''; ?>">
    
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

    <div class="form-group">
        <label for="offPageLink">Off Page Link</label>
        <input type="url" class="form-control" id="offPageLink" name="off_page_link" placeholder="Enter link" required>
    </div>

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
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Get the project ID from the URL
    const currentUrl = window.location.href;
    const projectIdMatch = currentUrl.match(/\/(\d+)$/); // Extract the last number from the URL
    const projectId = projectIdMatch ? projectIdMatch[1] : null;

    // Preselected dropdown option
    const projectName = $('#projectDropdownn').find('option:selected').text(); // Get selected project name
    fetchOffPageData(projectId);

    // Remove the selected attribute from any other option
    $('#projectDropdownn option').removeAttr('selected');

    // Set the selected attribute to the option that matches the selectedProjectId
    $('#projectDropdownn option[value="' + projectId + '"]').attr('selected', 'selected');

    if (projectId) {
        $('#projectDropdownn').val(projectId);
        updateNavigationLinks(projectId);
    }

    function updateNavigationLinks(projectId) {
        const adminBaseUrl = '<?php echo base_url("admin"); ?>';
        $('#offpageLink').attr('href', `${adminBaseUrl}/offpage/${projectId}`);
        $('#onpageLink').attr('href', `${adminBaseUrl}/onpage/${projectId}`);
        $('#keywordsLink').attr('href', `${adminBaseUrl}/keywords/${projectId}`);
        $('#rankingLink').attr('href', `${adminBaseUrl}/google_ranking/${projectId}`);
    }

    // Update navigation links on page load if project ID exists
    if (projectId) {
        updateNavigationLinks(projectId);
    }

    $('#projectDropdownn').change(function () {
        const selectedProjectId = $(this).val();
        if (selectedProjectId) {
            // Redirect to the updated URL for the selected project
            const newUrl = '<?php echo base_url("admin/offpage"); ?>/' + selectedProjectId;
            window.location.href = newUrl;
        }
    });

    // Fetch data for the selected project
    function fetchOffPageData(projectId) {
        $.ajax({
            url: '<?php echo base_url("Offpage_data/get_offpage_data"); ?>/' + projectId,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                const data = response.data || [];
                $('#offPageTableBody').html(
                    data.length
                        ? data
                              .map(
                                  (item, index) => `
                                  <tr>
                                      <td>${index + 1}.</td>
                                      <td>${item.project_name}</td>
                                      <td>${item.off_Category_name}</td>
                                      <td><a href="${item.off_page_link}" target="_blank">${item.off_page_link}</a></td>
                                      <td>${item.created_at}</td>
                                      <td>${item.updated_at}</td>
                                      <td>
                                          <button type="button" class="btn btn-sm btn-outline-success btn-icon-text" onclick="editOffPage(${item.id})">
                                              <i class="mdi mdi-marker btn-icon-prepend"></i> EDIT
                                          </button>
                                          <button type="button" class="btn btn-sm btn-outline-danger btn-icon-text" onclick="deleteOffPage(${item.id})">
                                              <i class="mdi mdi-account-off btn-icon-prepend"></i> DELETE
                                          </button>
                                      </td>
                                  </tr>
                              `
                              )
                              .join('')
                        : '<tr><td colspan="8">No data available for this project.</td></tr>'
                );
            },
            error: function () {
                alert('Failed to fetch data.');
            },
        });
    }

    // Add new data
    $('#offpageForm').submit(function (e) {
        e.preventDefault();
        console.log('Project ID:', $('#project_id').val());

        const projectId = $('#project_id').val(); // Get the hidden input's value
        if (!projectId) {
            alert('Please select a project.');
            return; // Stop submission
        }

        $.ajax({
            url: '<?php echo base_url("Offpage_data/add_offpage_data"); ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert('Data inserted successfully.');
                    fetchOffPageData(projectId); // Refresh the table
                    $('#offpageForm')[0].reset(); // Reset the form
                    $('#updateButton').hide(); // Hide update button if visible
                    $('#submitButton').show(); // Ensure the submit button is shown
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
                $('#entryId').val(data.id); // Set unique ID
                $('#offPageCategory').val(data.off_page_category);
                $('#offPageLink').val(data.off_page_link);

                // Switch form to update mode
                $('#submitButton').hide(); // Hide submit button
                $('#updateButton').show(); // Show update button
            },
            error: function () {
                alert('Failed to fetch data for editing.');
            },
        });
    };

    $('#updateButton').click(function () {
        const entryId = $('#entryId').val(); // Get the unique ID
        const projectId = $('#project_id').val(); // Get the project ID

        if (!entryId) {
            alert('No data selected for update.');
            return;
        }

        $.ajax({
            url: '<?php echo base_url("Offpage_data/update_offpage_data"); ?>',
            method: 'POST',
            data: $('#offpageForm').serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert('Data updated successfully.');
                    fetchOffPageData(projectId); // Refresh the table
                    resetForm(); // Reset the form
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
                        fetchOffPageData($('#project_id').val()); // Refresh table
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
        $('#offpageForm')[0].reset(); // Reset the form
        $('#entryId').val(''); // Clear the unique ID
        $('#submitButton').show(); // Show the submit button
        $('#updateButton').hide(); // Hide the update button
    }
});
</script>




























