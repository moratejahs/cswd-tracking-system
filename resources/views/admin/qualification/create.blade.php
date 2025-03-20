<div class="text-left modal fade" id="createBeneficiaryQualification" tabindex="-1" aria-labelledby="productNameTitle"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="productNameTitle">Create Beneficiary Qualifications</h4>
            </div>
            <div class="modal-body">
                <form id="store-product-form" action="{{ route('qualification.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label for="unit">Title <span class="text-danger">*</span></label>
                                <input id="unit" type="text" name="name" class="form-control"
                                    placeholder="Enter beneficiary qualifications" required>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label for="unit">Description <span class="text-danger">*</span></label>
                                <textarea id="unit" name="desc" class="form-control" placeholder="Enter descriptions" required rows="4"></textarea>
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
