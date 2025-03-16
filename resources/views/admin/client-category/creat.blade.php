<div class="text-left modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="productNameTitle"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="productNameTitle">Create Client Category</h4>
            </div>
            <div class="modal-body">
                <form id="store-product-form" action="{{ route('admin.client-categorie.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label for="unit">Client Category <span class="text-danger">*</span></label>
                                <input id="unit" type="text" name="description" class="form-control"
                                    placeholder="Enter client category" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <table class="table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th scope="col" class="text-white">Category Name</th>
                                        <th scope="col" class="text-white text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getcategories as $category)
                                        <tr>
                                            <th scope="row">{{ $category->description }}</th>
                                            <th scope="row" class="text-center">
                                                <a id="editCategory" href="javascript:void(0)"
                                                    data-user-id="{{ $category->id }}"
                                                    data-url="{{ route('admin.client-category.show', $category->id) }}"
                                                    class="btn btn-light-secondary rounded-pill btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a id="removeCategory" href="javascript:void(0)"
                                                    data-user-id="{{ $category->id }}"
                                                    data-url="{{ route('admin.client-category.show', $category->id) }}"
                                                    class="btn btn-danger rounded-pill btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
