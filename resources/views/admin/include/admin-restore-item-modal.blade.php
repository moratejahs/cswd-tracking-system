<div class="text-left modal fade" id="restore-product-modal" tabindex="-1" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="text-white modal-title" id="myModalLabel4">Restore Record?</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('restore.inventory') }}" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="restore-id" name="id" required>
                        <p>Are you sure do you want to restore?</p>
                    </div>
                    <div class="pb-2 col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-light-secondary me-1" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Confrim</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
