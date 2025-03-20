<div class="text-left modal fade" id="editQualificationModals" tabindex="-1" aria-labelledby="editQualificationModals"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="editQualificationModals">Edit Beneficiary Qualifications</h4>
            </div>
            <div class="modal-body">
                <form id="editQualificationFORM" action="{{ route('qualification.update') }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="row">
                        <input id="qualificationIdsss" type="text" name="id"
                            placeholder="Enter beneficiary qualifications" hidden required>
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label for="qualificationName">Title <span class="text-danger">*</span></label>
                                <input id="qualificationName" type="text" name="name" class="form-control"
                                    placeholder="Enter beneficiary qualifications" required autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label for="qualificationDes">Description <span class="text-danger">*</span></label>
                                <textarea id="qualificationDes" name="desc" class="form-control" placeholder="Enter descriptions" required
                                    rows="4" autocomplete="off"></textarea>
                            </div>
                        </div>

                        <div class="pb-2 col-12 d-flex justify-content-end">

                            <button type="submit" class="btn btn-primary" form="editQualificationFORM">
                                <div style="display: flex;">
                                    <div class="save-loader">
                                        <i class="bi bi-check2"></i>
                                    </div>
                                    <div class="preloader mx-2 mt-1" role="status"></div>
                                    <span id="save" class="d-none d-sm-block">Update</span>
                                </div>
                            </button>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
