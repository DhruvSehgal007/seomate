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
   
    <div class="seo-item on-page ">
        <a href="<?php echo base_url("admin/onpage/$projectid");?>" id="onpageLink">ON PAGE OPTIMIZATION</a>
    </div>
    <div class="seo-item off-page ">
        <a href="<?php echo base_url("admin/offpage/$projectid");?>" id="offpageLink">OFF PAGE OPTIMIZATION</a>
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
        <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 
                  <div class="table-responsive pt-3">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Keywords</th>
                <th>Ranking</th>
            </tr>
        </thead>
        <tbody id="rankingTableBody">
            <tr>
                <td colspan="3">Select a project to view data</td>
            </tr>
        </tbody>
    </table>
</div>

                </div>
              </div>
            </div>
           
          
        </div>
        <button type="button" id="submitRanking" class="btn btn-primary me-2">Submit</button>
       <button type="button" id="updateRanking" class="btn btn-warning" style="display: none;">Update</button>
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








    function getkeywords(projectId) {
    if (!projectId) {
        alert("Please select a project to view keywords.");
        return;
    }

    $.ajax({
        url: '<?php echo base_url("Google_ranking_data/fetch_keywords_by_project"); ?>/' + projectId,
        method: "GET",
        dataType: "json",
        success: function (response) {
            const rankingTableBody = $("#rankingTableBody");
            rankingTableBody.empty(); // Clear the table body

            if (response.status === "success" && response.data.length > 0) {
                response.data.forEach((item, index) => {
                    rankingTableBody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.keywords}</td>
                            <td>
                                <input type="text" class="form-control" name="ranking[]" placeholder="Enter Ranking" required>
                            </td>
                        </tr>
                    `);
                });
            } else {
                rankingTableBody.append('<tr><td colspan="3">No keywords found for this project.</td></tr>');
            }
        },
        error: function () {
            alert("Failed to fetch keywords. Please try again.");
        },
    });
}



$('#submitRanking').click(function () {
    const projectId = $('#project_id').val(); // Get the project ID
    const rankings = [];

    // Collect data from the table
    $('#rankingTableBody tr').each(function () {
        const keyword = $(this).find('td:nth-child(2)').text().trim(); // Get the keyword text
        const ranking = $(this).find('input[name="ranking[]"]').val().trim(); // Get the ranking value

        if (keyword && ranking) {
            rankings.push({ keyword, ranking });
        }
    });

    if (rankings.length === 0) {
        alert('Please enter at least one ranking.');
        return;
    }

    // Send data to the backend via AJAX
    $.ajax({
        url: '<?php echo base_url("Google_ranking_data/insert_rankings"); ?>',
        method: 'POST',
        data: {
            project_id: projectId,
            rankings: rankings
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert('Rankings saved successfully!');
                fetchrankingData(projectId); // Refresh the table data
            } else {
                alert(response.message || 'Failed to save rankings.');
            }
        },
        error: function () {
            alert('An error occurred. Please try again.');
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
                              <tr data-id="${item.id}">
                                  <td>${index + 1}</td>
                                  <td>${item.keywords}</td>
                                  <td class="ranking-cell">${item.ranking}</td>
                                  <td>
                                      <button type="button" class="btn btn-sm btn-outline-success edit-button" data-id="${item.id}">
                                          <i class="mdi mdi-marker"></i> Edit
                                      </button>

                                  </td>
                                  <td>
                                  <button type="button" class="btn btn-sm btn-outline-danger btn-icon-text delete-button" data-id="${item.id}">
                                          <i class="mdi mdi-account-off btn-icon-prepend"></i> DELETE
                                      </button>
                                  </td>
                              </tr>`
                          )
                          .join("")
                    : '<tr><td colspan="4">No data available for this project.</td></tr>'
            );
        },
        error: function () {
            alert("Failed to fetch data.");
        },
    });
}

// Event: Click on Edit Button
$(document).on("click", ".edit-button", function () {
    const row = $(this).closest("tr");
    const rankingCell = row.find(".ranking-cell");
    const rankingValue = rankingCell.text().trim();
    const id = row.data("id");

    // Replace ranking text with input field
    rankingCell.html(`<input type="text" class="form-control ranking-input" value="${rankingValue}" />`);

    // Change Edit button to Update button
    $(this).removeClass("edit-button btn-outline-success").addClass("update-button btn-outline-warning").html('<i class="mdi mdi-check"></i> Update');
});

// Event: Click on Update Button
$(document).on("click", ".update-button", function () {
    const row = $(this).closest("tr");
    const rankingInput = row.find(".ranking-input");
    const newRanking = rankingInput.val().trim();
    const id = row.data("id");
    const projectId = $("#project_id").val();

    if (!newRanking) {
        alert("Ranking cannot be empty.");
        return;
    }

    // Send updated ranking to the server
    $.ajax({
        url: '<?php echo base_url("Google_ranking_data/update_ranking"); ?>',
        method: "POST",
        data: { id, ranking: newRanking, project_id: projectId },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                alert("Ranking updated successfully!");

                // Replace input field with updated text
                rankingInput.closest(".ranking-cell").text(newRanking);

                // Change Update button back to Edit button
                row.find(".update-button").removeClass("update-button btn-outline-warning").addClass("edit-button btn-outline-success").html('<i class="mdi mdi-marker"></i> Edit');
            } else {
                alert(response.message || "Failed to update ranking.");
            }
        },
        error: function () {
            alert("An error occurred while updating ranking.");
        },
    });
});










function fetchTableData(projectId) {
        $.ajax({
            url: '<?php echo base_url("Google_ranking_data/get_ranking_by_project"); ?>/' + projectId,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    let tableRows = '';
                    response.data.forEach((item, index) => {
                        tableRows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.keywords}</td>
                                <td>
                                    <input type="text" class="form-control ranking-input" data-id="${item.id}" value="${item.ranking}">
                                </td>
                            </tr>
                        `;
                    });
                    $('#rankingTableBody').html(tableRows);
                } else {
                    $('#rankingTableBody').html('<tr><td colspan="3">No data found for the selected project.</td></tr>');
                }
            },
            error: function () {
                alert('Failed to fetch data.');
            },
        });
    }

































    // 
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

});

</script>
