<div class="content-wrapper">
    <div class="row">
    <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add On Page Categories</h4>
                    <div id="alertMessage"></div>

                    <form id="categoryForm" class="forms-sample">
                        <input type="hidden" id="categoryId" name="category_id">
                        <div class="form-group" id="categoryFields">
                            <label for="categoryName">Category Name</label>
                            <!-- Note the change here: name="category_name[]" -->
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
                    <h4 class="card-title">On Page Categories</h4>
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
                            <tbody id="categoriesTableBody" class="for_text">
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

    // Append new category input fields on "Add More" click
    $('#addMoreBtn').click(function(e) {
        e.preventDefault();
        $('#categoryFields').append(`
            <div class="form-group">
                <input type="text" class="form-control category-input" name="category_name[]" placeholder="Enter category">
            </div>
        `);
    });

    $('#categoryForm').on('submit', function(e) {
        e.preventDefault();
        let categoryId = $('#categoryId').val();
        let url = $('#submitButton').text() === 'Update' 
            ? '<?php echo base_url('On_page_category/update_category'); ?>' 
            : '<?php echo base_url('On_page_category/add_category'); ?>';

        // Serialize the entire form, which now may contain multiple category_name[] fields
        $.ajax({
            url: url,
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                $('#alertMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                $('#categoryForm')[0].reset();
                $('#categoryId').val('');
                $('#submitButton').text('Submit');
                loadCategories();
            },
            error: function() {
                $('#alertMessage').html('<div class="alert alert-danger">An error occurred.</div>');
            }
        });
    });

    function loadCategories() {
        $.ajax({
            url: '<?php echo base_url('On_page_category/get_categories'); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(categories) {
                let tableBody = '';
                $.each(categories, function(index, category) {
                    tableBody += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${category.on_category_name}</td>
                            <td>${new Date(category.created_at).toLocaleString('en-US', { dateStyle: 'medium', timeStyle: 'short' })}</td>
                            <td>${new Date(category.updated_at).toLocaleString('en-US', { dateStyle: 'medium', timeStyle: 'short' })}</td>
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

    window.editCategory = function(category_id) {
        $.ajax({
            url: '<?php echo base_url('On_page_category/get_category'); ?>/' + category_id,
            method: 'GET',
            dataType: 'json',
            success: function(category) {
                $('#categoryId').val(category.category_id);
                $('#categoryName').val(category.on_category_name);
                $('#submitButton').text('Update');
                // Disable add more when editing, as editing should only modify one category at a time
                $('#addMoreBtn').prop('disabled', true).fadeTo('fast', 0.5);
            }
        });
    };

    window.deleteCategory = function(category_id) {
        if (confirm("Do you really want to delete this category?")) {
            $.ajax({
                url: '<?php echo base_url('On_page_category/delete_category'); ?>/' + category_id,
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    loadCategories();
                }
            });
        }
    };
});

</script>
