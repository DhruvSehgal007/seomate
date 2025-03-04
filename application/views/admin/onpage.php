<style>
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-btn {
      padding: 10px 20px;
      border: 1px solid #ccc;
      background-color: #f9f9f9;
      cursor: pointer;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      border: 1px solid #ccc;
      min-width: 200px;
      z-index: 1;
    }

    .dropdown-content label {
      display: block;
      padding: 5px;
      cursor: pointer;
    }

    .dropdown-content label:hover {
      background-color: #f1f1f1;
    }

    .show {
      display: block;
    }
  </style>
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
    
    <div class="seo-item on-page active">
        <a href="<?php echo base_url("admin/onpage/$projectid");?>" id="onpageLink">ON PAGE OPTIMIZATION</a>
    </div>
    <div class="seo-item off-page ">
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


<div class="content-wrapper">
    <!-- <h2>Project Name</h2> -->
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">On Page Information</h4>
<form id="onPageForm" method="POST">
    <input type="hidden" name="project_id" id="project_id" value="<?php echo $projectid; ?>">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Categories</th>
                <th>Checkbox</th>
            </tr>
        </thead>
        <tbody id="onPageTableBody">
            <!-- Dynamic categories and subcategories will be inserted here -->
        </tbody>
    </table>
    <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
</form>




                </div>
            </div>
        </div>
        
        <!-- Off Page Data Table -->
        <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="card-title">On Page Data </h4>
                        
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
    <tbody id="onPageDataBody">
        <tr><td colspan="7">Select a project to view data</td></tr>
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
    loadOnPageCategories();
    loadCategoriesWithSubcategories();
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
 
    const dropdownBtn = document.querySelector('.dropdown-btn');
    const dropdownContent = document.querySelector('.dropdown-content');

    dropdownBtn.addEventListener('click', () => {
      dropdownContent.classList.toggle('show');
    });

    window.addEventListener('click', (e) => {
      if (!e.target.matches('.dropdown-btn') && !e.target.closest('.dropdown-content')) {
        dropdownContent.classList.remove('show');
      }
    });



    function loadOnPageCategories() {
        $.ajax({
            url: '<?php echo base_url("Onpage_data/fetch_on_page_categories"); ?>',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    let categories = response.data;
                    let tableBody = '';
                    $.each(categories, function (index, category) {
                        tableBody += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${category.on_category_name}</td>
                               
                                <td>
                                    
                                </td>
                            </tr>`;
                    });
                    $('#onPageTableBody').html(tableBody);
                } else {
                    $('#onPageTableBody').html('<tr><td colspan="5">No categories found.</td></tr>');
                }
            },
            error: function () {
                alert('Failed to fetch categories.');
            }
        });
    }











    function loadCategoriesWithSubcategories() {
    $.ajax({
        url: '<?php echo base_url("Onpage_data/fetch_categories_with_subcategories"); ?>',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let categories = response.data;
                let tableBody = '';
                $.each(categories, function (index, category) {
                    let checkboxColumn = '';

                    if (category.subcategories.length > 0) {
                        // If subcategories exist, create a dropdown with checkboxes
                        checkboxColumn = `
                            <div class="dropdown">
                                <div class="dropdown-btn">Select Options</div>
                                <input type="hidden" value="${category.category_id}" name="categories[]"></input>
                                <div class="dropdown-content">
                                    ${category.subcategories
                                        .map(
                                            (sub) =>
                                                `<label>
                                                    <input type="checkbox" class="form-check-input" value="${sub.sub_category_id}"  name="subcategories[]"  >
                                                    ${sub.sub_category_name}
                                                </label>`
                                        )
                                        .join('')}
                                </div>
                            </div>
                        `;
                    } else {
                        // If no subcategories, show a single checkbox
                        checkboxColumn = `
                            <div class="form-check form-check-success">
                                <input type="checkbox" class="form-check-input" value="${category.category_id}"  name="categories[]" >
                                
                            </div>
                        `;
                    }

                    tableBody += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${category.on_category_name}</td>
                            <td>${checkboxColumn}</td>
                        </tr>`;
                });
                $('#onPageTableBody').html(tableBody);
 
                // Add dropdown functionality
                $('.dropdown-btn').on('click', function () {
                    $(this).siblings('.dropdown-content').toggleClass('show');
                });
                $(window).on('click', function (e) {
                    if (!$(e.target).hasClass('dropdown-btn') && !$(e.target).closest('.dropdown-content').length) {
                        $('.dropdown-content').removeClass('show');
                    }
                });
            } else {
                $('#onPageTableBody').html('<tr><td colspan="3">No categories found.</td></tr>');
            }
        },
        error: function () {
            alert('Failed to fetch categories and subcategories.');
        },
    });
}









});


$(document).ready(function () {
    $('#onPageForm').submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        const projectId = $('#project_id').val(); // Capture Project ID
        const selectedData = [];

        // Loop through all category rows dynamically
        $('#onPageTableBody').find('tr').each(function () {
            const categoryCheckbox = $(this).find('input[name="categories[]"]'); // Delegate for category checkbox
            const isCategoryChecked = categoryCheckbox.is(':checked'); // Check if category is selected
            const categoryId = categoryCheckbox.val(); // Get category ID
            const categoryName = $(this).find('td:nth-child(2)').text().trim(); // Get category name

            const subcategories = [];
            // Delegate for subcategory checkboxes within the current row
            $(this).find('input[name="subcategories[]"]:checked').each(function () {
                subcategories.push({
                    id: $(this).val(),
                    name: $(this).parent().text().trim(),
                });
            });

            // Add the category to selectedData if either it or its subcategories are selected
            if (isCategoryChecked || subcategories.length > 0) {
                selectedData.push({
                    category_id: categoryId,
                    category_name: categoryName,
                    subcategories: subcategories,
                });
            }
        });

        // Log the results for debugging
        console.log('Project ID:', projectId);
        console.log('Selected Data:', selectedData);

        $.ajax({
    url: '<?php echo base_url("Onpage_data/insert_onpage_data"); ?>', // URL to your controller method
    method: 'POST',
    data: {
        project_id: projectId, // Sending the project_id
        selected_data: selectedData, // Sending the selected categories, renamed to selected_data to match your PHP code
    },
    success: function (response) {
        console.log("Response:", response); // Log the response
        alert('Data submitted successfully.'); // Notify user on success
    },
    error: function (xhr, status, error) {
        console.log('Error:', error); // Log any error
        alert('Error in form submission.'); // Notify user on error
    }
});


    });

    // Delegate for dynamically created category checkboxes
    $(document).on('change', 'input[name="categories[]"]', function () {
        console.log('Category checkbox changed:', $(this).val());
    });

    // Delegate for dynamically created subcategory checkboxes
    $(document).on('change', 'input[name="subcategories[]"]', function () {
        console.log('Subcategory checkbox changed:', $(this).val());
    });
});


$(document).ready(function () {
    // Fetch data for the table based on the project ID
    function fetchData(projectId) {
        $.ajax({
            url: '<?php echo base_url("Onpage_data/fetch_onpage_data"); ?>/' + projectId,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                let tableBody = '';
                if (response.status === 'success') {
                    response.data.forEach((item, index) => {
                        tableBody += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.project_name || 'N/A'}</td>
                                <td>${item.on_category_name || 'N/A'}</td>
                                <td>${item.sub_category_name || '----'}</td>
                                <td>${item.created_at || 'N/A'}</td>
                                <td>${item.updated_at || 'N/A'}</td>
                                <td>Action</td>
                            </tr>
                        `;
                    });
                } else {
                    tableBody = '<tr><td colspan="7">No data found for the selected project.</td></tr>';
                }
                $('#onPageDataBody').html(tableBody);
            },
            error: function () {
                alert('Failed to fetch data for the project.');
            }
        });
    }

    // Call fetchData when the page loads if a project ID is available
    const currentProjectId = $('#project_id').val();
    if (currentProjectId) {
        fetchData(currentProjectId);
    }

    // Reload data when project is changed in the dropdown
    $('#projectDropdownn').change(function () {
        const selectedProjectId = $(this).val();
        if (selectedProjectId) {
            fetchData(selectedProjectId);
        }
    });
});


</script>
