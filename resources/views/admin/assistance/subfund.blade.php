<div class="text-left modal fade" id="createSubFund" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="false"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="myModalLabel4">New Assistance</h4>
            </div>
            <div class="modal-body">
                <form id="filterForm" action="{{ route('sub-fund.store') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="text" id="assistanceIdssss" hidden name="assistance_id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="start_date">Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="end_date">Amount</label>
                            <input type="number" id="amount" name="amount" required class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label for="end_date">Purpose</label>
                            <input type="text" id="purpose" name="purpose" required class="form-control">
                        </div>
                        <div class="col-md-12 d-flex align-items-end">
                            <button type="submit" id="filterButton" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
