<div class="content-wrapper">
    <div class="row">
        <!-- Form for adding categories -->
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Off Page Categories</h4>
                    <div id="alertMessage"></div> <!-- Display alert messages here -->

                    <form id="categoryForm" class="forms-sample">
                        <input type="hidden" id="categoryId" name="category_id">
                        <div id="categoryFields">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" class="form-control category-input" id="categoryName" name="categories[]" placeholder="Enter category">
                            </div>
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

        <!-- Table displaying categories -->
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Off Page Categories</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered offpage_cat_table">
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
                                <!-- Categories will be populated here by AJAX -->
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
    // Load initial categories
    loadCategories();

    // Add more input fields for categories
    $('#addMoreBtn').click(function(e) {
        e.preventDefault();
        $('#categoryFields').append(`
            <div class="form-group">
                <input type="text" class="form-control category-input" name="categories[]" placeholder="Enter category">
            </div>
        `);
    });

    // Handle form submission for adding or updating categories
    $('#categoryForm').on('submit', function(e) {
        e.preventDefault();

        let catId = $('#categoryId').val();
        let categories = $("input[name='categories[]']").map(function() {
            return $(this).val();
        }).get();

        let url = $('#submitButton').text() === 'Update' 
            ? '<?php echo base_url('Off_page_category/update_category'); ?>' 
            : '<?php echo base_url('Off_page_category/add_categories'); ?>';

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                'cat_id': catId,
                'categories': categories
            },
            dataType: 'json',
            success: function(response) {
                $('#alertMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                $('#categoryForm')[0].reset();
                $('#categoryId').val(''); // Clear the hidden category ID
                $('#submitButton').text('Submit'); // Reset button to Submit after update
                $('#addMoreBtn').prop('disabled', false).removeClass('disabled-btn'); // Enable Add More button
                loadCategories(); // Reload categories to reflect the changes
            },
            error: function(xhr) {
                $('#alertMessage').html('<div class="alert alert-danger">An error occurred.</div>');
            }
        });
    });

    // Load categories into the table
    function loadCategories() {
        $.ajax({
            url: '<?php echo base_url('Off_page_category/get_categories'); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(categories) {
                let tableBody = '';
                $.each(categories, function(index, category) {
                    tableBody += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${category.off_Category_name}</td>
                            <td>${category.created_at}</td>
                            <td>${category.updated_at}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="editCategory(${category.category_id})">EDIT</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteCategory(${category.category_id})">DELETE</button>
                            </td>
                        </tr>`;
                });
                $('#categoriesTableBody').html(tableBody);
            }
        });
    }

    // Function to edit a category
    window.editCategory = function(category_id) {
        $.ajax({
            url: '<?php echo base_url('Off_page_category/get_category'); ?>/' + category_id,
            method: 'GET',
            dataType: 'json',
            success: function(category) {
                $('#categoryId').val(category.category_id);  // Set hidden category_id for update
                $('#categoryName').val(category.off_Category_name); // Set category name
                $('#submitButton').text('Update'); // Change button to "Update"
                
                // Disable the "Add More" button and fade it
                $('#addMoreBtn').prop('disabled', true).addClass('disabled-btn');
            }
        });
    };

    // Function to delete a category with confirmation
    window.deleteCategory = function(category_id) {
        if (confirm("Do you really want to delete this category?")) {
            $.ajax({
                url: '<?php echo base_url('Off_page_category/delete_category'); ?>/' + category_id,
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    loadCategories(); // Reload categories after deletion
                }
            });
        }
    };
});

</script>
