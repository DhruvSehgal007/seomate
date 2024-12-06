<div class="content-wrapper">
    <!-- <h2>Manage Users</h2> -->
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Information</h4>
                    <form class="forms-sample">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">First Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter First Name">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Last Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Last Name">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                <label for="exampleInputEmail1">E-mail</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Email">
                                </div>

                                <div class="col-md-6">
                                    
                                        <label for="exampleInputEmail1">Username</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Username">
                                    
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" class="form-control" id="exampleInputEmail1" placeholder="Enter Password">
                                </div>

                                <div class="col-md-6">
                                    
                                <label for="keywordSelect">Role</label>
                                    <select class="form-control" id="keywordSelect">
                                        <option selected disabled>Select Role</option>
                                        <option>Admin</option>
                                        <option>SEO team member</option>
                                        <option>Manager</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2 mt-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Table -->
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Users Data</h4>
                <div class="table-responsive">
                    <table class="table table-bordered newbt">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th colspan="2" class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>Dhruv</td>
                                <td>Sehgal</td>
                                <td>sehgaldhruv422001@gmail.com</td>
                                <td>techdhruvseo</td>
                                <td>422001</td>
                                <td>Admin</td>
                                <td class="action-btns">
                                    <button type="button" class="btn btn-sm btn-outline-success btn-icon-text">
                                        <i class="mdi mdi-marker btn-icon-prepend"></i> EDIT
                                    </button>
                                </td>
                                <td class="action-btns">
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-icon-text">
                                        <i class="mdi mdi-account-off btn-icon-prepend"></i> DELETE
                                    </button>
                                </td>
                            </tr>
                            
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
