<div class="text-left modal fade" id="store-product-modal" tabindex="-1" aria-labelledby="productNameTitle"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="productNameTitle">New Product</h4>
            </div>
            <div class="modal-body">
                <form id="store-product-form" action="{{ route('store.inventory') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="product-name">Product Description <span class="text-danger">*</span></label>
                                <textarea name="product_name" class="form-control jelmaxx-form" id="product-name"  rows="5" placeholder="Enter description..." required></textarea>
                                {{-- <select id="product-name" name="product_name"
                                    class="product-select-2 form-select form-select-lg"
                                    style="width: 100%; height: 600px;" required>
                                    @foreach ($descriptions as $description)
                                        <option value="{{ $description->product_name }}">
                                            {{ $description->product_name }}</option>
                                    @endforeach
                                </select> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="category">Product Type <span class="text-danger">*</span></label>
                                <select id="category" name="category_name"
                                    class="category-select-2 form-select form-select-lg"
                                    style="width: 100%; height: 600px;">
                                    @foreach ($categories as $categories)
                                        <option value="{{ $categories->category_name }}">{{ $categories->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="supplier-name">Supplier <span class="text-danger">*</span></label>
                                <select id="supplier-name" name="supplier_name"
                                    class="supplier-select-2 form-select form-select-lg"
                                    style="width: 100%; height: 600px;">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->supplier_name }}">
                                            {{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 mb-2">
                            <div class="form-group">
                                <label for="qty">Qty <span class="text-danger">*</span></label>
                                <input id="qty" type="number" step="0.01" name="quantity" min="1"
                                    class="form-control text-center jelmaxx-form" placeholder="00" required>
                            </div>
                        </div>
                        <div class="col-5 mb-2">
                            <div class="form-group">
                                <label for="unit">Unit <span class="text-danger">*</span></label>
                                <input id="unit" type="text" name="unit" min="1"
                                    class="form-control text-center jelmaxx-form" placeholder="Enter Unit" required>
                            </div>
                        </div>
                        <div class="col-5 mb-2">
                            <div class="form-group">
                                <label for="cost-price">Cost Price </label>
                                <input id="cost-price" type="number" name="cost_price" step="0.01" min="1"
                                    class="form-control text-center jelmaxx-form" placeholder="00">
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="sale-price">Jelmaxx Hardware Sale Price</label>
                                <input id="sale-price" type="number" name="sell_price" min="1" step="0.01"
                                    class="form-control text-center jelmaxx-form" placeholder="00">
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <div class="form-group">
                                <label for="sale-price">Jenneth Marketing Sale Price</label>
                                <input id="sale-price" type="number" name="sell_price_two" min="1" step="0.01"
                                    class="form-control text-center jelmaxx-form" placeholder="00">
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
                                    <span id="save" class="d-none d-sm-block">Save</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
