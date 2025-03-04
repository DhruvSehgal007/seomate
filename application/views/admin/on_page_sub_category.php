<div class="content-wrapper">
    <div class="row">
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add On Page Sub Categories</h4>
                    <div id="alertMessage"></div>

                    <form id="subCategoryForm" class="forms-sample">
                        <input type="hidden" id="subCategoryId" name="sub_category_id">
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" id="categorySelect" name="category_id">
                                <option selected disabled>Select Category</option>
                            </select>
                        </div>
                        <div id="subCategoryFields">
                            <div class="form-group">
                                <label>Sub Category</label>
                                <input type="text" class="form-control sub-category-input" name="sub_categories[]" placeholder="Enter sub-category">
                            </div>
                        </div>
                        <div><button type="button" id="addMoreBtn" class="btn addtext">Add More +</button></div>
                        
                        <button type="submit" id="submitButton" class="btn btn-primary me-2">Submit</button>
                        <button type="reset" class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">On Page Sub Categories</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered onpagesubtable">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Category</th>
                                    <th>Sub-Category</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="subCategoriesTableBody"></tbody>
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
    // Load categories into dropdown
    loadCategories();
    loadSubCategories();

    $('#addMoreBtn').click(function(e) {
        e.preventDefault();
        $('#subCategoryFields').append(`
            <div class="form-group">
                <input type="text" class="form-control sub-category-input" name="sub_categories[]" placeholder="Enter sub-category">
            </div>
        `);
    });

    $('#subCategoryForm').on('submit', function(e) {
        e.preventDefault();

        let url = $('#submitButton').text() === 'Update'
            ? '<?php echo base_url('On_page_sub_category/update_sub_category'); ?>'
            : '<?php echo base_url('On_page_sub_category/add_sub_category'); ?>';

        $.ajax({
            url: url,
            method: 'POST',
            data: $('#subCategoryForm').serialize(),
            dataType: 'json',
            success: function(response) {
                $('#alertMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                $('#subCategoryForm')[0].reset();
                $('#submitButton').text('Submit');
                loadSubCategories();
            },
            error: function(xhr) {
                $('#alertMessage').html('<div class="alert alert-danger">An error occurred.</div>');
            }
        });
    });

    // Function to load categories into dropdown
    function loadCategories() {
        $.ajax({
            url: '<?php echo base_url('On_page_sub_category/get_categories'); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(categories) {
                let options = '<option selected disabled>Select Category</option>';
                $.each(categories, function(index, category) {
                    options += `<option value="${category.category_id}">${category.on_category_name}</option>`;
                });
                $('#categorySelect').html(options);
            },
            error: function(xhr, status, error) {
                console.error("Error loading categories: ", error);
            }
        });
    }

    // Function to load sub-categories into the table
    function loadSubCategories() {
        $.ajax({
            url: '<?php echo base_url('On_page_sub_category/get_sub_categories'); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(subCategories) {
                let tableBody = '';
                $.each(subCategories, function(index, subCategory) {
                    tableBody += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${subCategory.on_category_name}</td>
                            <td>${subCategory.sub_category_name}</td>
                            <td>${subCategory.created_at}</td>
                            <td>${subCategory.updated_at}</td>
                            
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="editSubCategory(${subCategory.sub_category_id})">EDIT</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteSubCategory(${subCategory.sub_category_id})">DELETE</button>
                            </td>
                        </tr>`;
                });
                $('#subCategoriesTableBody').html(tableBody);
            }
        });
    }

    // Function to edit a sub-category
    window.editSubCategory = function(sub_category_id) {
        $.ajax({
            url: '<?php echo base_url('On_page_sub_category/get_sub_category'); ?>/' + sub_category_id,
            method: 'GET',
            dataType: 'json',
            success: function(subCategory) {
                $('#subCategoryId').val(subCategory.sub_category_id);
                $('#categorySelect').val(subCategory.category_id);
                $('#subCategoryFields .sub-category-input').val(subCategory.sub_category_name);
                $('#submitButton').text('Update');
            }
        });
    };

    // Function to delete a sub-category with confirmation
    window.deleteSubCategory = function(sub_category_id) {
        if (confirm("Do you really want to delete this sub-category?")) {
            $.ajax({
                url: '<?php echo base_url('On_page_sub_category/delete_sub_category'); ?>/' + sub_category_id,
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    loadSubCategories();
                }
            });
        }
    };
});


</script>
