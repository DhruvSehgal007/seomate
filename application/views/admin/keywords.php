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
                        <option selected>Choose a project</option>
                        <?php foreach ($projects as $project): 
                            $project_id = $project['project_id'];
                            if ($projectid == $project_id) { ?>
                                <option value="<?php echo $project['project_id']; ?>" selected><?php echo $project['project_name']; ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $project['project_id']; ?>"><?php echo $project['project_name']; ?></option>
                            <?php } ?>
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
   
    <div class="seo-item on-page ">
        <a href="<?php echo base_url("admin/onpage/$projectid");?>" id="onpageLink">ON PAGE OPTIMIZATION</a>
    </div>
    <div class="seo-item off-page ">
        <a href="<?php echo base_url("admin/offpage/$projectid");?>" id="offpageLink">OFF PAGE OPTIMIZATION</a>
    </div>
    <div class="seo-item keywords active">
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
            <h4 class="card-title">Add Keywords</h4>
            <form class="forms-sample" id="keywordsForm" enctype="multipart/form-data">
                <input type="hidden" id="entryId" name="id" value="">
                <input type="hidden" id="project_id" name="project_id" value="<?php echo $projectid; ?>">

                <div id="keywordsContainer">
                    <div class="form-group">
                        <label for="keywords">Keywords</label>
                        <input type="text" class="form-control keywords-field" name="keywords[]" placeholder="Enter Keywords">
                    </div>
                </div>
                <div class="form-group">
        <label for="excelFile">Upload Excel File</label>
        <input type="file" id="excelFile" class="form-control" accept=".xlsx, .xls">
    </div>

                <button type="button" class="btn btn-secondary me-2" id="addMoreButton">Add More</button>
                <button type="submit" class="btn btn-primary me-2" id="submitButton">Submit</button>
                <button type="button" id="updateButton" class="btn btn-warning" style="display: none;">Update</button>
            </form>
        </div>
    </div>
</div>


        <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Keywords Data</h4>
            <div class="table-responsive">
            <button id="downloadExcelButton" class="btn btn-success mt-3">Download Keywords in Excel</button>
                <table class="table table-bordered newbt" id="keywordsTable">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Keywords</th>
                            <!-- <th>Created on</th>
                            <th>Updated on</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="kywordsTableBody">
        <tr><td colspan="6">Select a project to view data</td></tr>
    </tbody>
                </table>
               
            </div>
        </div>
    </div>
</div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    const currentUrl = window.location.href;
    const projectIdMatch = currentUrl.match(/\/(\d+)$/); // Extract the last number from the URL
    const projectId = projectIdMatch ? projectIdMatch[1] : null;
    fetchkeywordsData();
    fetchkeywordsData(projectId);

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
            const newUrl = `<?php echo base_url("admin/keywords"); ?>/${selectedProjectId}`;
            window.location.href = newUrl; // Reload the page with the new project ID in the URL
        } else {
            alert('Please select a valid project.'); // Handle invalid selections
        }
        
    
    });





    $('#keywordsForm').submit(function (e) {
    e.preventDefault(); // Prevent default form submission

    // Collect all keyword fields
    const keywords = $('.keywords-field')
        .map(function () {
            return $(this).val().trim();
        })
        .get();

    if (keywords.length === 0) {
        alert('Please enter or upload at least one keyword.');
        return;
    }

    // Submit via AJAX
    $.ajax({
        url: '<?php echo base_url("keywords_data/save_keywords_data"); ?>',
        method: 'POST',
        data: {
            project_id: $('#project_id').val(),
            keywords: keywords.join(','),
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert('Keywords saved successfully!');
                $('#keywordsForm')[0].reset(); // Reset the form
                $('#keywordsContainer').html(`
                    <div class="form-group">
                        <label for="keywords">Keywords</label>
                        <input type="text" class="form-control keywords-field" name="keywords[]" placeholder="Enter Keywords">
                    </div>
                `); // Reset the form container
                fetchkeywordsData($('#project_id').val()); // Refresh the table
            } else {
                alert(response.message || 'Failed to save keywords.');
            }
        },
        error: function () {
            alert('An error occurred. Please try again.');
        },
    });
});




    function fetchkeywordsData(projectId) {
    $.ajax({
        url: '<?php echo base_url("keywords_data/get_keywords_data"); ?>/' + projectId,
        method: "GET",
        dataType: "json",
        success: function (response) {
            const data = response.data || [];
            $("#kywordsTableBody").html(
                data.length
                    ? data
                          .map(
                              (item, index) => `
                              <tr>
                                  <td>${index + 1}.</td>
                                  <td>${item.keywords}</td>
                                 
                                  <td>
                                      <button type="button" class="btn btn-sm btn-outline-success btn-icon-text edit-button" data-id="${item.id}">
                                          <i class="mdi mdi-marker btn-icon-prepend"></i> EDIT
                                      </button>
                                      <button type="button" class="btn btn-sm btn-outline-danger btn-icon-text delete-button" data-id="${item.id}">
                                          <i class="mdi mdi-account-off btn-icon-prepend"></i> DELETE
                                      </button>
                                  </td>
                              </tr>`
                          )
                          .join("")
                    : '<tr><td colspan="8">No data available for this project.</td></tr>'
            );
        },
        error: function () {
            alert("Failed to fetch data.");
        },
    });
   }

    



// Event delegation for dynamically added DELETE buttons
$(document).on('click', '.delete-button', function () {
    const id = $(this).data('id');
    // alert(id);
    if (confirm('Are you sure you want to delete this data?')) {
        $.ajax({
            url: '<?php echo base_url("Keywords_data/delete_keywords_data"); ?>/' + id,
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert('Data deleted successfully.');
                    fetchkeywordsData($('#project_id').val()); // Refresh the table
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


// edit data

$(document).on("click", ".edit-button", function () {
    const id = $(this).data("id"); // Get the unique ID of the keyword
    $.ajax({
        url: '<?php echo base_url("keywords_data/get_keywords_data_by_id"); ?>/' + id,
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            // Populate the form fields with the fetched data
            $("#entryId").val(response.id); // Set the unique ID
            $("#keywordsContainer").html(`
                <div class="form-group">
                    <label for="keywords">Keywords</label>
                    <input type="text" class="form-control keywords-field" name="keywords[]" value="${response.keywords}" placeholder="Enter Keywords">
                </div>
            `);

            // Switch to update mode
            $("#submitButton").hide(); // Hide the submit button
            $("#updateButton").show(); // Show the update button
        },
        error: function () {
            alert("Failed to fetch data for editing.");
        },
    });
});


// Update button click event
$("#updateButton").click(function () {
    const entryId = $("#entryId").val(); // Get the unique ID
    const projectId = $("#project_id").val(); // Get the project ID
    const keywords = $(".keywords-field").val().trim(); // Get the updated keyword

    if (!entryId) {
        alert("No data selected for update.");
        return;
    }

    $.ajax({
        url: '<?php echo base_url("keywords_data/update_keywords_data"); ?>',
        method: "POST",
        data: {
            id: entryId,
            project_id: projectId,
            keywords: keywords,
        },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                alert("Keyword updated successfully!");
                fetchkeywordsData(projectId); // Refresh the table
                resetForm(); // Reset the form
            } else {
                alert(response.message || "Failed to update keyword.");
            }
        },
        error: function () {
            alert("Failed to update keyword.");
        },
    });
});



$('#addMoreButton').click(function () {
        const newField = `
            <div class="form-group additional-keywords">
                <label for="keywords">Keywords</label>
                <input type="text" class="form-control keywords-field" name="keywords[]" placeholder="Enter Keywords">
            </div>`;
        $('#keywordsContainer').append(newField);
    });

    function resetForm() {
    $("#keywordsForm")[0].reset(); // Reset the form
    $("#entryId").val(""); // Clear the unique ID
    $("#submitButton").show(); // Show the submit button
    $("#updateButton").hide(); // Hide the update button
    $("#keywordsContainer").html(`
        <div class="form-group">
            <label for="keywords">Keywords</label>
            <input type="text" class="form-control keywords-field" name="keywords[]" placeholder="Enter Keywords">
        </div>
    `); // Reset the form container
}

document.getElementById('downloadExcelButton').addEventListener('click', function () {
    // Fetch the project name from the page
    const projectName = document.getElementById('projectName').textContent.trim() || 'Project';

    // Fetch table data
    const table = document.getElementById('keywordsTable');
    const rows = table.querySelectorAll('tbody tr');

    // Prepare data for Excel (only Sr.No. and Keywords columns)
    const excelData = [];
    excelData.push(['Sr.No.', 'Keywords']); // Table headers

    rows.forEach((row) => {
        const cells = row.querySelectorAll('td');
        if (cells.length > 1) { // Skip rows with "No data available"
            const srNo = cells[0].textContent.trim(); // Sr.No.
            const keyword = cells[1].textContent.trim(); // Keywords
            excelData.push([srNo, keyword]); // Push only Sr.No. and Keywords
        }
    });

    // Create a new workbook and worksheet
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.aoa_to_sheet(excelData);
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Keywords');

    // Export Excel file with the project name
    const fileName = `${projectName.replace(/\s+/g, '_')}_keywords.xlsx`;
    XLSX.writeFile(workbook, fileName);
});




});



document.getElementById('excelFile').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            const firstSheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[firstSheetName];
            const keywords = XLSX.utils.sheet_to_json(worksheet, { header: 1 }); // Get data as array
            
            // Clear existing fields
            document.getElementById('keywordsContainer').innerHTML = '';

            // Populate fields with keywords from Excel
            keywords.forEach((row) => {
                if (row[0]) {
                    document.getElementById('keywordsContainer').innerHTML += `
                        <div class="form-group">
                            <input type="text" class="form-control keywords-field" name="keywords[]" value="${row[0]}" placeholder="Enter Keywords">
                        </div>
                    `;
                }
            });
        };
        reader.readAsArrayBuffer(file);
    }
});

</script>