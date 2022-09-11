<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <form action="" method="POST" id="UpdateProductForm">
        @csrf
        <input type="hidden" name="u_id" id="u_id" />
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">Update product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="errorMsgContainer mb-2">
                </div>

                <div class="form-group">
                    <label for="name"> Product Name </label>
                    <input type="text" class="form-control" name="u_name" id="u_name" placeholder="Product Name" />
                </div>
                <div class="form-group mt-2">
                    <label for="name"> Product Price </label>
                    <input type="text" class="form-control" name="u_price" id="u_price"  placeholder="Product Price"  />
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-info update_product">Update </button>
            </div>
        </div>
        </div>
    </form>    
  </div>