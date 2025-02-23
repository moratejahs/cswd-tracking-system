<div class="text-left modal fade" id="store-category-modal" tabindex="-1" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="myModalLabel4">New Category</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('store.category') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="pb-2 col-12">
                            <div class="form-group">
                                <label for="category-name">Category Name <span class="text-danger">*</span></label>
                                <input id="category-name" name="category_name" type="text" class="form-control jelmaxx-form" required="" oninvalid="this.setCustomValidity('Category is required')">
                            </div>
                        </div>
                        <div class="pb-2 col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-light-secondary me-1" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
