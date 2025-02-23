<div class="text-left modal fade" id="product-stock-in-modal" tabindex="-1" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="myModalLabel4">Add Stock</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('store.stock-in') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div>
                                <small class="text-muted">Product Description</small>
                                <input type="hidden" id="product-stock-in-id" name="id">
                                <input type="hidden" id="product-stock-quantity-val" name="val_quantity">
                            </div>
                            <div>
                                <h5 class=" fst-italic text-secondary"><label
                                        id="product-stock-in-product_name"></label></>
                            </div>
                            <div>
                                <span class="text-muted"><small>Code:</small></span>
                                <small><span class="badge bg-success"><label
                                            id="product-view-stock-in-product-code"></label></span></small>
                            </div>
                        </div>

                        <div class="col-6 pt-2">
                            <span class="text-muted"><small>Remaining Qty:</small></span>
                            <label id="product-stock-in-quantity"></label>
                        </div>
                        <div class="col-6 pt-2">
                            <span class="text-muted"><small>Unit:</small></span>
                            <label id="product-stock-in-unit"></label>
                        </div>
                        <div class="col-6 pt-2">
                            <span class="text-muted"><small> Cost Price:</small></span>
                            <span style="font-weight: 700;"><label id="product-stock-in-cost-price"></label></span>
                        </div>
                        <div class="col-3 pt-2">
                            <span class="text-muted"><small>J.H Sale Price:</small></span>
                            <span style="font-weight: 700;"><label id="product-stock-in-sell-price"></label></span>
                        </div>
                        <div class="col-3 pt-2">
                            <span class="text-muted"><small>J.M Sale Price:</small></span>
                            <span style="font-weight: 700;"><label id="product-stock-in-sell-price-two"></label></span>
                        </div>
                        <hr>
                        <div class="col-12 pb-2">
                            <div class="row mb-12">
                                <label class="col-sm-3 col-form-label">New Stock <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="number" name="new_stock" class="form-control jelmaxx-form text-center"
                                        placeholder="00" min="0" id="new-stock" required>
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
                                <span class="d-none d-sm-block">Add</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
