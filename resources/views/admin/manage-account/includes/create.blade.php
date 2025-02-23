<div class="text-left modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="productNameTitle"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="productNameTitle">Create Account</h4>
            </div>
            <div class="modal-body">
                <form id="store-product-form" action="{{ route('admin.manage_account.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <small>Account complete name</small>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="unit">First Name <span class="text-danger">*</span></label>
                                <input id="unit" type="text" name="first_name" class="form-control text-center"
                                    placeholder="Enter first name" required>
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="cost-price">Middle Name <span class="text-danger">*</span></label>
                                <input id="cost-price" type="text" name="middle_name"
                                    class="form-control text-center" placeholder="Enter middle name">
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="form-group">
                                <label for="sale-price">Last Name <span class="text-danger">*</span></label>
                                <input id="sale-price" type="text" name="last_name" class="form-control text-center"
                                    placeholder="Enter last name">
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="sale-price">Position <span class="text-danger">*</span></label>
                                <input id="sale-price" type="text" name="position" class="form-control text-center"
                                    placeholder="Enter position">
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="sale-price">Email <span class="text-danger">*</span></label>
                                <input id="sale-price" type="email" name="email" class="form-control text-center"
                                    placeholder="Enter email">
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="sale-price">Username <span class="text-danger">*</span></label>
                                <input id="sale-price" type="text" name="username" class="form-control text-center"
                                    placeholder="Enter username">
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="sale-price">Password <span class="text-danger">*</span></label>
                                <input id="sale-price" type="password" name="password" class="form-control text-center"
                                    placeholder="Enter password">
                            </div>
                        </div>
                        <div class="pb-2 col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-light-secondary me-1" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button id="submit-button" type="submit" class="btn btn-primary">
                                <div style="display: flex;">
                                    <div class="save-loader">
                                        <i class="bi bi-check2"></i>
                                    </div>
                                    <div class="preloader mx-2 mt-1" role="status"></div>
                                    <span id="save" class="d-none d-sm-block">Submit</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
