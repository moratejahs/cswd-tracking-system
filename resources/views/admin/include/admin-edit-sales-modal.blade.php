<div class="text-left modal fade" id="edit-sales-modal" tabindex="-1" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="myModalLabel4">Edit Sale</h4>
            </div>
            <div class="modal-body">
                <form id="saleUpdateForm" method="POST">
                    @csrf
                    @method('patch')
                    <input id="editSaleProductId" type="hidden" name="product_id">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="row">
                                <div id="product-details">
                                    <div class="row px-3">
                                        <div class="col-12">
                                            <div>
                                                <small class="text-muted">Product Description</small>
                                            </div>
                                            <div>
                                                <h5 id="editProductName" class="fst-italic text-secondary">
                                                    Product Name
                                                </h5>
                                            </div>
                                            <div>
                                                <span class="text-muted"><small>Code:</small></span>
                                                <small>
                                                    <span id="editProductCode" class="badge bg-success">
                                                        0001
                                                    </span>
                                                </small>
                                            </div>
                                            <div>
                                                <span class="text-muted"><small>Supplier:</small></span>
                                                <small><label id="editProductSupplier"></label></small>
                                            </div>
                                        </div>
                                        <div class="col-6 pt-2">
                                            <span class="text-muted"><small>Remaining Qty:</small></span>
                                            <label id="editProductRemainingQty"></label>
                                        </div>
                                        <div class="col-6 pt-2">
                                            <span class="text-muted"><small>Unit:</small></span>
                                            <label id="editProductUnit"></label>
                                        </div>
                                        <div class="col-6 pt-2">
                                            <span class="text-muted"><small>Cost Price:</small></span>
                                            <span style="font-weight: 700;"><label id="editProductCostPrice"></label>
                                            </span>
                                        </div>
                                        <div class="col-6 pt-2">
                                            <span class="text-muted"><small>Sale Price:</small></span>

                                            <div class="d-flex">
                                                <div class="me-4">
                                                    <input type="radio" id="jhSalePrice" name="sell_price"
                                                        value="">
                                                    <label id="jhSalePriceLabel" style="font-weight: 700;"
                                                        for="jhSalePrice"></label><br>
                                                </div>
                                                <div>
                                                    <input type="radio" id="jmSalePrice" name="sell_price"
                                                        value="">
                                                    <label id="jmSalePriceLabel" style="font-weight: 700;"
                                                        for="jmSalePrice"></label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="editQty">Qty <span class="text-danger">*</span></label>
                                <input id="editQty" type="number" step="0.01" name="quantity" min="1"
                                    class="form-control text-center jelmaxx-form" placeholder="00" required>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="editAmount">Amount</label>
                                <input id="editAmount" type="number" step="0.01" name="amount" min="1"
                                    class="form-control text-center jelmaxx-form" placeholder="00" required>
                            </div>
                        </div>
                        <div class="pb-2 col-12 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="remainingQuantity me-5"></span>
                                <span class="estimatedProfit"></span>
                            </div>
                            <div>
                                <button type="button" class="btn btn-light-secondary me-1 close-button"
                                    data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary update-button">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save Changes</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
