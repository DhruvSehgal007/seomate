<div class="content-wrapper">
    <div class="row">
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Industry Type</h4>
                    <div id="alertMessage"></div>

                    <form id="Industry_categoryForm" class="forms-sample">
                   
                        <input type="hidden" id="categoryId" name="category_id">
                        <div class="form-group">
                            <!-- <label for="categoryName">Category Name</label> -->
                            <input type="text" class="form-control" id="categoryName" name="category_name[]" placeholder="Enter category">
                        </div>
                        <div class="cancelbtndiv">
                            <button type="button" id="addMoreBtn" class="btn addtext">Add More +</button>
                        </div>
                        <button type="submit" id="submitButton" class="btn btn-primary me-2">Submit</button>
                        <button type="reset" class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Industry Types</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Categories</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesTableBody">
                                <!-- Data will be populated here via AJAX -->
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
    loadCategories();

    // Add More Categories Dynamically
    $('#addMoreBtn').click(function(e) {
        e.preventDefault();
        $('#categoryFields').append(`
            <div class="form-group">
                <input type="text" class="form-control category-input" name="category_name[]" placeholder="Enter category">
            </div>
        `);
    });

    // Edit Button Click
    $(document).on('click', '.editBtn', function() {
        let categoryId = $(this).data('id');
        let categoryName = $(this).data('name');

        // Populate the input field with category name
        $('#categoryId').val(categoryId);
        $('#categoryName').val(categoryName);

        // Change the submit button text to 'Update'
        $('#submitButton').text('Update');
    });

    // Form Submit (Add or Update)
    $('#Industry_categoryForm').on('submit', function(e) {
        e.preventDefault();

        let categoryId = $('#categoryId').val(); // Get the category id for update
        let categoryNames = [];
        // Loop through each dynamically added category input and push to array
        $('input[name="category_name[]"]').each(function() {
            categoryNames.push($(this).val());
        });

        let url = categoryId ? '<?php echo base_url('Industry_category/update_category'); ?>' : '<?php echo base_url('Industry_category/add_categories'); ?>';
        let data = categoryId ? { category_id: categoryId, categories: categoryNames } : { categories: categoryNames };

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                $('#alertMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                $('#Industry_categoryForm')[0].reset();
                $('#submitButton').text('Submit'); // Reset button text
                loadCategories();
            },
            error: function() {
                $('#alertMessage').html('<div class="alert alert-danger">An error occurred.</div>');
            }
        });
    });

    // Delete Button Click
    $(document).on('click', '.deleteBtn', function() {
        let categoryId = $(this).data('id');
        
        if (confirm("Are you sure you want to delete this category?")) {
            $.ajax({
                url: '<?php echo base_url('Industry_category/delete_category'); ?>',
                method: 'POST',
                data: { category_id: categoryId },
                dataType: 'json',
                success: function(response) {
                    $('#alertMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                    loadCategories();
                },
                error: function() {
                    $('#alertMessage').html('<div class="alert alert-danger">An error occurred while deleting the category.</div>');
                }
            });
        }
    });

    // Load Categories for Table
    function loadCategories() {
        $.ajax({
            url: '<?php echo base_url('Industry_category/get_categories'); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let tableBody = '';
                response.categories.forEach(function(category, index) {
                    tableBody += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${category.industry_name}</td>
                            <td>${category.created_at}</td>
                            <td>${category.updated_at}</td>
                            <td>
                                <button class="btn btn-warning editBtn" data-id="${category.category_id}" data-name="${category.industry_name}">Edit</button>
                                <button class="btn btn-danger deleteBtn" data-id="${category.category_id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $('#categoriesTableBody').html(tableBody);
            },
            error: function() {
                $('#categoriesTableBody').html('<tr><td colspan="5" class="text-center">Failed to load categories.</td></tr>');
            }
        });
    }
});


</script>

