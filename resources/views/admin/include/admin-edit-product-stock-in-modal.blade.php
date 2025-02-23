<div class="text-left modal fade" id="edit-product-stock-in-modal" tabindex="-1" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="myModalLabel4">View Product</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.stock-in') }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-12">
                            <div>
                                <small class="text-muted">Product Description</small>
                                <input type="hidden" id="product-view-stock-in-id" name="id">

                            </div>
                            <div>
                                <h5 class=" fst-italic text-secondary"><label for=""
                                        id="product-view-stock-in-product_name"></label></>
                            </div>

                        </div>

                        <div class="col-6 pt-2">
                            <span class="text-muted"><small>Remaining Qty:</small></span>
                            <label for="" id="product-view-stock-in-quantity"></label>
                        </div>
                        <div class="col-6 pt-2">
                            <span class="text-muted"><small>Unit:</small></span>
                            <label for="" id="product-view-stock-in-unit"></label>
                        </div>
                        <div class="col-6 pt-2">
                            <span class="text-muted"><small> Cost Price:</small></span>
                            <span style="font-weight: 700;"><label for=""
                                    id="product-view-stock-in-cost-price"></label></span>
                        </div>
                        <div class="col-6 pt-2">
                            <span class="text-muted"><small>Sale Price:</small></span>
                            <span style="font-weight: 700;"><label for=""
                                    id="product-view-stock-in-sell-price"></label></span>
                        </div>
                        <hr>
                        <div class="col-12 pb-2">
                            <div class="row mb-12">
                                <label for="new-stock" class="col-sm-4 col-form-label">Remaining Stock</label>
                                <div class="col-sm-8">
                                    <input type="number" name="quantity" class="form-control jelmaxx-form text-center"
                                        placeholder="00" min="0" id="product-view-stock-quantity" required>
                                </div>
                            </div>
                        </div>
                        <div class="pb-2 col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-light-secondary me-1" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save Changes</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
