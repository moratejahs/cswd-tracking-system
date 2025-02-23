<div class="text-left modal fade" id="store-sale-modal" tabindex="-1" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="myModalLabel4">New Sale</h4>
            </div>
            <div class="modal-body">
                <form id="salesCreateForm" action="{{ route('sales.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="product-name">Product Description <span class="text-danger">*</span></label>
                                <select id="product-name" name="product_id"
                                    class="sale-select-2 form-select form-select-lg" style="width: 100%; height: 600px;"
                                    required>
                                    <option></option>
                                    @foreach ($descriptions as $description)
                                        <option value="{{ $description->id }}">
                                            {{ $description->code }} - {{ $description->product_name }} -
                                            {{ $description->supplier_name }} (J.H: ₱ {{ $description->sell_price }})- (J.M: ₱ {{ $description->sell_price_two }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="row">
                                <div id="product-details">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="qty">Qty <span class="text-danger">*</span></label>
                                <input id="qty" type="number" step="0.01" name="quantity" min="1"
                                    class="form-control text-center jelmaxx-form" placeholder="00" required>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input id="amount" type="number" step="0.01" name="amount" min="1"
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
                                <button type="submit" class="btn btn-primary save-button">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
