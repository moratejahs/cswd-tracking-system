<div class="text-left modal fade" id="store-sale-modal-two" tabindex="-1" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title">Quick Sale</h4>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" id="salesCreateFormTwo" method="POST">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="qsProdDesc">Product Description <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="qsProdDesc" class="form-control" name="product_desc"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="qsQty">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" id="qsQty" class="form-control" name="quantity"
                                        step="0.01" placeholder="00" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="qsAmount">Amount <span class="text-danger">*</span></label>
                                    <input type="text" id="qsAmount" class="form-control" name="amount"
                                        placeholder="00" required>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-light-secondary me-1 mb-1"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary me-1 mb-1 qs-save-button">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
