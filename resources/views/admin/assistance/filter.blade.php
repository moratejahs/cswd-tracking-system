<div class="text-left modal fade" id="createFilter" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="false"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="myModalLabel4">Date Range Filter</h4>
            </div>
            <div class="modal-body">
                <form id="filterForm" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="start_date">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="form-control">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" id="filterButton" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
