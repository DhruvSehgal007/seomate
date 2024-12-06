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
    <div class="seo-item off-page ">
        <a href="<?php echo base_url("admin/offpage/$projectid");?>" id="offpageLink">OFF PAGE OPTIMIZATION</a>
    </div>
    <div class="seo-item on-page active">
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


<div class="content-wrapper">
    <!-- <h2>Project Name</h2> -->
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">On Page Information</h4>
                    <form class="forms-sample" id="onpageForm">
                    <input type="hidden" id="entryId" name="id" value="">

                    <input type="hidden" id="project_id" name="project_id" value="<?php echo $selected_project['project_id'] ?? ''; ?>">

                    
                    <div class="form-group">
    <label for="exampleFormControlSelect2">On Page Category</label>
    <select class="form-control" id="exampleFormControlSelect2" name="on_page_category">
    <option disabled selected>Choose a category</option>
</select>
</div>

                        
<div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sr.No.</th>
                <th>Activities</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="activitiesTable">
            <tr>
                <td colspan="3">Select a category to view activities</td>
            </tr>
        </tbody>
    </table>
</div>

                       
                        
                        <!-- <button type="submit" class="btn btn-primary me-2">Submit</button> -->
                        <button type="submit" class="btn btn-primary me-2" id="submitButton">Submit</button>
   
   <button type="button" id="updateButton" class="btn btn-warning" style="display: none;">Update</button>
                        <button type="button" class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Off Page Data Table -->
        <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="card-title">Off Page Data </h4>
                        
                        <div class="table-responsive">
                        <table class="table table-bordered">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Project Name</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Added On</th>
            <th>Updated On</th>
            <th class="action">Action</th>
        </tr>
    </thead>
    <tbody id="onPageTableBody">
        <tr><td colspan="6">Select a project to view data</td></tr>
    </tbody>
</table>


                        </div>
                        </div>
                    </div>
                </div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    const currentUrl = window.location.href;
    const projectIdMatch = currentUrl.match(/\/(\d+)$/); // Extract the last number from the URL
    const projectId = projectIdMatch ? projectIdMatch[1] : null;
    fetchOnPageCategories();
    fetchOnPageData(projectId);


    // Preselect the dropdown option based on the project ID
    if (projectId) {
        $('#projectDropdownn option').removeAttr('selected');
        $('#projectDropdownn option[value="' + projectId + '"]').attr('selected', 'selected');
        $('#projectName').text($('#projectDropdownn option:selected').text());
        updateNavigationLinks(projectId);
    }

    function updateNavigationLinks(projectId) {
        const adminBaseUrl = '<?php echo base_url("admin"); ?>';
        $('#offpageLink').attr('href', `${adminBaseUrl}/offpage/${projectId}`);
        $('#onpageLink').attr('href', `${adminBaseUrl}/onpage/${projectId}`);
        $('#keywordsLink').attr('href', `${adminBaseUrl}/keywords/${projectId}`);
        $('#rankingLink').attr('href', `${adminBaseUrl}/google_ranking/${projectId}`);
    }

    // When the dropdown value changes
    $('#projectDropdownn').change(function () {
        const selectedProjectId = $(this).val(); // Get selected project ID
        const selectedProjectName = $(this).find('option:selected').text(); // Get selected project name

        if (selectedProjectId) {
            $('#projectName').text(selectedProjectName); // Update project name display
            const newUrl = `<?php echo base_url("admin/onpage"); ?>/${selectedProjectId}`;
            window.location.href = newUrl; // Reload the page with the new project ID in the URL
        } else {
            alert('Please select a valid project.'); // Handle invalid selections
        }
        
  
    });

    function fetchOnPageCategories(){
         // Fetch categories
         $.ajax({
            url: '<?php echo base_url("onpage_data/fetch_categories"); ?>',
            method: 'GET',
            dataType: 'json',
            success: function (categories) {
                $('#exampleFormControlSelect2').empty().append('<option disabled selected>Choose a category</option>');
                if (categories.length > 0) {
                    categories.forEach(category => {
                        $('#exampleFormControlSelect2').append(
                            `<option value="${category.category_id}">${category.on_category_name}</option>`
                        );
                    });
                } else {
                    $('#exampleFormControlSelect2').append('<option disabled>No categories available</option>');
                }
            },
            error: function () {
                alert('Failed to fetch categories. Please try again.');
            }
        });
    }

    function fetchOnPageData(projectId) {
    $.ajax({
        url: '<?php echo base_url("Onpage_data/get_onpage_data"); ?>/' + projectId,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            const data = response.data || [];
            $('#onPageTableBody').html(
                data.length
                    ? data
                          .map(function (item, index) {
                              return `
                              <tr>
                                  <td>${index + 1}.</td>
                                  <td>${item.project_name}</td>
                                  <td>${item.on_category_name}</td>
                                  <td>${item.on_page_sub_category_names}</td> <!-- Display the subcategory names -->
                                  <td>${item.created_at}</td>
                                  <td>${item.updated_at}</td>
                                  <td>
                                      <button type="button" class="btn btn-sm btn-outline-success btn-icon-text edit-button" data-id="${item.id}">
                                          <i class="mdi mdi-marker btn-icon-prepend"></i> EDIT
                                      </button>
                                      <button type="button" class="btn btn-sm btn-outline-danger btn-icon-text delete-button" data-id="${item.id}">
                                          <i class="mdi mdi-account-off btn-icon-prepend"></i> DELETE
                                      </button>
                                  </td>
                              </tr>
                          `;
                          })
                          .join('')
                    : '<tr><td colspan="8">No data available for this project.</td></tr>'
            );
        },
        error: function () {
            alert('Failed to fetch data.');
        },
    });
}




    // Fetch subcategories based on selected category
    $('#exampleFormControlSelect2').change(function () {
        const categoryId = $(this).val();
        $('#categoryIdInput').val(categoryId); // Set hidden input for category

        // Clear the table
        $('#activitiesTable').html('<tr><td colspan="3">Loading...</td></tr>');

        // Fetch subcategories via AJAX
        $.ajax({
            url: '<?php echo base_url("onpage_data/fetch_sub_categories"); ?>/' + categoryId,
            method: 'GET',
            dataType: 'json',
            success: function (subCategories) {
                if (subCategories.length > 0) {
                    let tableRows = '';
                    subCategories.forEach((subCategory, index) => {
                        tableRows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${subCategory.sub_category_name}</td>
                                <td>
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input custom-checkbox" name="on_page_sub_category[]" value="${subCategory.sub_category_id}">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                    $('#activitiesTable').html(tableRows);
                } else {
                    $('#activitiesTable').html('<tr><td colspan="3">No activities found for this category</td></tr>');
                }
            },
            error: function () {
                $('#activitiesTable').html('<tr><td colspan="3">Failed to fetch activities. Please try again.</td></tr>');
            }
        });
    });

    // Handle form submission
//     $('#onpageForm').submit(function (e) {
//     e.preventDefault(); // Prevent default form submission

//     // Log form data before submission
//     console.log($(this).serialize()); // This will show the data being sent to the server

//     // Submit selected project, category, and subcategories
//     $.ajax({
//         url: '<?php echo base_url("onpage_data/save_onpage_data"); ?>',
//         method: 'POST',
//         data: $(this).serialize(),
//         dataType: 'json',
//         success: function (response) {
//             console.log(response); // Log the response to see any errors from the server
//             if (response.status === 'success') {
//                 alert('Data saved successfully!');
//                 fetchOnPageData($('#project_id').val()); // Refresh the data table
//             } else {
//                 alert(response.message || 'Failed to save data.');
//             }
//         },
//         error: function () {
//             alert('Failed to submit data. Please try again.');
//         }
//     });
// });

$('#onpageForm').submit(function (e) {
    e.preventDefault(); // Prevent default form submission

    $.ajax({
        url: '<?php echo base_url("onpage_data/save_onpage_data"); ?>',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert('Data saved successfully!');
                fetchOnPageData($('#project_id').val()); // Refresh the data table
            } else {
                alert(response.message || 'Failed to save data.'); // Show error message for duplicates
            }
        },
        error: function () {
            alert('Failed to submit data. Please try again.');
        }
    });
});






$(document).on('click', '.delete-button', function () {
    const id = $(this).data('id');
    if (confirm('Are you sure you want to delete this data?')) {
        $.ajax({
            url: '<?php echo base_url("Onpage_data/delete_onpage_data"); ?>/' + id,
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert('Data deleted successfully.');
                    fetchOnPageData($('#project_id').val()); // Refresh the table
                } else {
                    alert('Failed to delete data.');
                }
            },
            error: function () {
                alert('Failed to delete data.');
            },
        });
    }
});


$(document).on('click', '.edit-button', function () {
    const id = $(this).data('id');
    
    // Fetch data for the selected entry
    $.ajax({
        url: '<?php echo base_url("Onpage_data/edit_onpage_data"); ?>/' + id,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            const data = response.data;
            const categories = response.categories;
            const subCategories = response.subCategories;

            // Pre-fill the category dropdown
            $('#exampleFormControlSelect2').val(data.on_page_category);

            // Clear previous activities table
            $('#activitiesTable').empty();

            // Populate sub-category checkboxes
            const selectedSubCategories = data.on_page_sub_category.split(','); // Assuming this is a comma-separated string
            let tableRows = '';
            
            // Loop through all fetched subcategories
            subCategories.forEach((subCategory, index) => {
                const isChecked = selectedSubCategories.includes(subCategory.sub_category_id.toString()) ? 'checked' : '';
                tableRows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${subCategory.sub_category_name}</td>
                        <td>
                            <div class="form-check form-check-success">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input custom-checkbox" name="on_page_sub_category[]" value="${subCategory.sub_category_id}" ${isChecked}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </td>
                    </tr>`;
            });

            $('#activitiesTable').html(tableRows); // Populate the table with rows

            // Show the update button and hide the submit button
            $('#submitButton').hide();
            $('#updateButton').show().data('id', id);
        },
        error: function () {
            alert('Failed to fetch data for editing.');
        }
    });
});


$('#updateButton').click(function () {
    const id = $(this).data('id');
    const project_id = $('#project_id').val();
    const on_page_category = $('#exampleFormControlSelect2').val();
    const on_page_sub_category = []; // Collect selected sub-categories

    $('#activitiesTable input[type="checkbox"]:checked').each(function () {
        on_page_sub_category.push($(this).val());
    });

    // Make sure to send the data correctly as an object
    $.ajax({
        url: '<?php echo base_url("onpage_data/save_onpage_data"); ?>',
        method: 'POST',
        data: {
            id: id,
            project_id: project_id,
            on_page_category: on_page_category,
            on_page_sub_category: on_page_sub_category // Send as an array
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert('Data updated successfully!');
                fetchOnPageData(project_id); // Refresh the table with updated data
                $('#submitButton').show();
                $('#updateButton').hide();
            } else {
                alert(response.message || 'Failed to update data.');
            }
        },
        error: function () {
            alert('Failed to update data.');
        }
    });
});


});

</script>
