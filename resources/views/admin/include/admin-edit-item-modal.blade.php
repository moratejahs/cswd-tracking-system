<div class="text-left modal fade" id="edit-product-modal" tabindex="-1" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="myModalLabel4">View Product Information</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.inventory') }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <input type="hidden" id="product-id" name="id">
                            <div class="form-group">
                                <label for="product-product_name">Product Description <span
                                        class="text-danger">*</span></label>
                                <textarea id="product-product_name" name="product_name" class="form-control jelmaxx-form" id="product-name"
                                    rows="5" placeholder="Enter description..." required></textarea>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div>
                                <span class="text-muted"><small>Code:</small></span>
                                <small><span class="badge bg-success"><label for=""
                                            id="product-code"></label></span></small>
                            </div>
                        </div>
                        <div class="col-2 mb-2">
                            <div class="form-group">
                                <label for="product-quantity">Qty <span class="text-danger">*</span></label>
                                <input id="product-quantity" type="number" name="quantity" min="1"
                                    class="form-control text-center jelmaxx-form" placeholder="00" required>
                            </div>
                        </div>
                        <div class="col-5 mb-2">
                            <div class="form-group">
                                <label for="product-unit">Unit <span class="text-danger">*</span></label>
                                <input id="product-unit" type="text" name="unit" min="1"
                                    class="form-control text-center jelmaxx-form" placeholder="Enter Unit" required>
                            </div>
                        </div>
                        <div class="col-5 mb-2">
                            <div class="form-group">
                                <label for="product-cost_price">Cost Price <span class="text-danger">*</span></label>
                                <input id="product-cost_price" type="text" name="cost_price" min="1"
                                    class="form-control text-center jelmaxx-form" placeholder="00" required>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="product-sell_price">Jelmaxx Hardware Sale Price<span
                                        class="text-danger">*</span></label>
                                <input id="product-sell_price" type="number" name="sell_price" min="1"
                                    step="0.01" class="form-control text-center jelmaxx-form" placeholder="00"
                                    required>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="sale-price">Jenneth Marketing Sale Price<span
                                        class="text-danger">*</span></label>
                                <input id="product-sell_price_two" type="number" name="sell_price_two" min="1"
                                    step="0.01" class="form-control text-center jelmaxx-form" placeholder="00">
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
