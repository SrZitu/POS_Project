<div class="modal .custom-modal" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Create Category</h4>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                    <i class="fas fa-list-alt prefix grey-text"></i>
                    <label class="form-label">Category Name *</label>
                    <input type="text" class="form-control" id="categoryName">
                </div>

                <div class="modal-footer">
                    <button id="modal-close" class="btn btn-sm custom-btn" data-bs-dismiss="modal">Close</button>
                    <button onclick="store()" id="save-btn" class="btn btn-sm custom-btn">Save</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        async function store() {

            let categoryName = document.getElementById('categoryName').value;

            if (categoryName.length === 0) {
                errorToast('Category Required');
            } else {

                document.getElementById('modal-close').click();

                showLoader();
                let res = await axios.post("/createCategory", {
                    name: categoryName
                })
                hideLoader();

                if (res.status === 201) {
                    successToast('Request Successful');
                    document.getElementById("save-form").reset();
                    await getList();
                } else {
                    errorToast("Request fail !")
                }
            }
        }
    </script>
