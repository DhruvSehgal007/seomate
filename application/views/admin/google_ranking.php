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
									<option disabled selected>Choose a project</option>
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
 <div class="seo-bar">
    <div class="seo-item off-page ">
        <a href="<?php echo base_url("admin/offpage/$projectid");?>" id="offpageLink">OFF PAGE OPTIMIZATION</a>
    </div>
    <div class="seo-item on-page ">
        <a href="<?php echo base_url("admin/onpage/$projectid");?>" id="onpageLink">ON PAGE OPTIMIZATION</a>
    </div>
    <div class="seo-item keywords">
        <a href="<?php echo base_url("admin/keywords/$projectid");?>" id="keywordsLink">KEYWORDS</a>
    </div>
    <div class="seo-item ranking active">
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
                    <h4 class="card-title">Keywords</h4>
                    <form id="rankingForm" class="forms-sample">
                    <input type="hidden" id="entryId" name="id" value="">

<input type="hidden" id="project_id" name="project_id" value="<?php echo $selected_project['project_id'] ?? ''; ?>">
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">
                <label for="keywordSelect">Keywords</label>
                <select class="form-control" id="keywordSelect" name="keyword">
                    <option selected disabled>Select your keyword</option>
                    <!-- Options will be populated dynamically via AJAX -->
                </select>
            </div>
            <div class="col-md-3">
                <label for="yearSelect">Year</label>
                <select class="form-control" id="yearSelect" name="year">
                    <option selected disabled>Select Year</option>
                    <option>2024</option>
                    <option>2023</option>
                    <option>2022</option>
                    <option>2021</option>
                    <option>2020</option>
                    <option>2019</option>
                    <option>2018</option>
                    <option>2017</option>
                    <option>2016</option>
                    <option>2015</option>
                    <option>2014</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="monthSelect">Month</label>
                <select class="form-control" id="monthSelect" name="month">
                    <option selected disabled>Select Month</option>
                    <option>January</option>
                    <option>February</option>
                    <option>March</option>
                    <option>April</option>
                    <option>May</option>
                    <option>June</option>
                    <option>July</option>
                    <option>August</option>
                    <option>September</option>
                    <option>October</option>
                    <option>November</option>
                    <option>December</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="rankingInput">Ranking</label>
                <input type="text" class="form-control" id="rankingInput" name="ranking" placeholder="Enter Ranking" required>
            </div>
        </div>
        <button type="button" id="submitRanking" class="btn btn-primary me-2">Submit</button>
        <button type="button" id="updateButton" class="btn btn-warning" style="display: none;">Update</button>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Keywords Data</h4>
                    <div class="table-responsive">
                    <table class="table table-bordered newbt" id="rankingTabledatatable">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Keywords</th>
                            <th>Ranking</th>

                            <th>Created on</th>
                            <th>Updated on</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="rankingTable">
        <tr><td colspan="6">Select a project to view data</td></tr>
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
    // Get the project ID from the URL
    const currentUrl = window.location.href;
    const projectIdMatch = currentUrl.match(/\/(\d+)$/); // Extract the last number from the URL
    const projectId = projectIdMatch ? projectIdMatch[1] : null;
    getkeywords(projectId);
    // fetchrankingData();
    fetchrankingData(projectId);



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
            const newUrl = `<?php echo base_url("admin/google_ranking"); ?>/${selectedProjectId}`;
            window.location.href = newUrl; // Reload the page with the new project ID in the URL
            getkeywords(selectedProjectId);
        } else {
            alert('Please select a valid project.'); // Handle invalid selections
        }
    });



// 

// 

function getkeywords(selectedProjectId){
    var project_id = selectedProjectId;
    if (project_id) {
            // AJAX request to fetch keywords based on selected project_id
            $.ajax({
                url: '<?php echo base_url("Google_ranking_data/get_keywords_by_project"); ?>', // Adjust this URL as per your controller's function
                type: 'POST',
                data: { project_id: project_id },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Clear the existing keywords in the dropdown
                        var keywordSelect = $('#keywordSelect');
                        keywordSelect.empty();
                        
                        // Append a default "Select Keyword" option
                        keywordSelect.append('<option selected disabled>Select your keyword</option>');
                        
                        // Populate the dropdown with keywords
                        $.each(response.keywords, function(index, keyword) {
                            keywordSelect.append('<option value="' + keyword.id + '">' + keyword.keywords + '</option>');
                        });
                    } else {
                        alert(response.message); // Show an error if no keywords found
                    }
                },
                error: function() {
                    alert('Error while fetching keywords. Please try again.');
                }
            });
        } else {
            // Reset the dropdown if no project is selected
            $('#keywordSelect').empty().append('<option selected disabled>Select your keyword</option>');
        }

}
$('#submitRanking').click(function() {
        // Capture form data
        var keyword = $('#keywordSelect').val();
        var year = $('#yearSelect').val();
        var month = $('#monthSelect').val();
        var ranking = $('#rankingInput').val();
        var project_id = $('#projectDropdownn').val();  // Assuming you have a project ID dropdown

        // Validate the inputs
        if (!keyword || !year || !month || !ranking || !project_id) {
            alert("Please fill in all fields.");
            return;
        }

        // Send the data via AJAX
        $.ajax({
            url: '<?php echo base_url('Google_ranking_data/insert_ranking_data'); ?>', // Update URL
            type: 'POST',
            data: {
                keyword: keyword,
                year: year,
                month: month,
                ranking: ranking,
                project_id: project_id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Data inserted successfully!');
                    // Optionally, clear the form or do other UI updates here
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error while submitting data. Please try again.');
            }
        });
    });



    function fetchrankingData(projectId) {
    $.ajax({
        url: '<?php echo base_url("Google_ranking_data/get_ranking_data"); ?>/' + projectId,
        method: "GET",
        dataType: "json",
        success: function (response) {
            const data = response.data || [];
            $("#rankingTable").html(
                data.length
                    ? data
                          .map(
                              (item, index) => ` 
                              <tr>
                                  <td>${index + 1}.</td>
                                  <td>${item.keywords}</td> <!-- Display keyword name -->
                                  <td>${item.ranking}</td>
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



$(document).on('click', '.delete-button', function () {
    const id = $(this).data('id');
    if (confirm('Are you sure you want to delete this data?')) {
        $.ajax({
            url: '<?php echo base_url("Google_ranking_data/delete_ranking_data"); ?>/' + id,
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

// 
$(document).on("click", ".edit-button", function () {
    const id = $(this).data("id"); // Get ID from button's data attribute
    $.ajax({
        url: '<?php echo base_url("Google_ranking_data/get_ranking_data_by_id"); ?>/' + id,
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            // Populate the form fields with the fetched data
            $("#entryId").val(response.id); // Set the unique ID
            $("#keywordSelect").val(response.keywords); // Populate the keyword dropdown
            $("#rankingInput").val(response.ranking); // Populate the ranking field
            $("#yearSelect").val(response.year); // Populate the year field
            $("#monthSelect").val(response.month); // Populate the month field

            // Switch to update mode
            $("#submitButton").hide(); // Hide the submit button
            $("#updateButton").show(); // Show the update button
        },
        error: function () {
            alert("Failed to fetch data for editing.");
        },
    });
});


$("#updateButton").click(function () {
    const entryId = $("#entryId").val(); // Get the unique ID
    const projectId = $("#project_id").val(); // Get the project ID

    if (!entryId) {
        alert("No data selected for update.");
        return;
    }

    // Prepare data for update
    const formData = $("#rankingForm").serializeArray();
    let data = {};

    // Convert the serialized data into an object
    $.each(formData, function (i, field) {
        data[field.name] = field.value;
    });

    // Ensure the data uses the correct column names
    data['keywords'] = $("#keywordSelect").val(); // Get the value of the selected keyword from the dropdown
    data['ranking'] = $("#rankingInput").val(); // Get the ranking input value

    // If 'keywordSelect' is part of the serialized data, ensure we update it as 'keywords'
    // Send the AJAX request with the updated data
    $.ajax({
        url: '<?php echo base_url("Google_ranking_data/update_ranking_data"); ?>',
        method: "POST",
        data: data, // Send the updated data
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                alert("Data updated successfully!");
                fetchkeywordsData(projectId); // Refresh the table
                resetForm(); // Reset the form
            } else {
                alert(response.message || "Failed to update data.");
            }
        },
        error: function () {
            alert("Failed to update data.");
        },
    });
});



function resetForm() {
    $("#rankingForm")[0].reset(); // Reset the form
    $("#entryId").val(""); // Clear the unique ID
    $("#submitButton").show(); // Show the submit button
    $("#updateButton").hide(); // Hide the update button
}

});
</script>
