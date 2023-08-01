<div class="modal .custom-modal" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="updateForm">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Create Category</h4>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i class="fas fa-list-alt prefix grey-text"></i>
                        <label class="form-label">Category Name *</label>
                        <input type="text" class="form-control" id="categoryNameUpdate">
                        <input class="d-none" id="updateId">
                    </div>

                    <div class="modal-footer">
                        <button id="modal-close" class="btn btn-sm custom-btn" data-bs-dismiss="modal">Close</button>
                        <button onclick="update()" id="save-btn" class="btn btn-sm custom-btn">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    async function updatedFormId(id) {
        document.getElementById('updateId').value = id;
        showLoader()
        response = await axios.post('CategoryId', {
            id: id
        })
        hideLoader()
        document.getElementById('categoryNameUpdate').value = response.data['name']
    }

    async function update() {

        let categoryName = document.getElementById('categoryNameUpdate').value;
        let updateId = document.getElementById('updateId').value;
        if (categoryName.length === 0) {
            errorToast('Category Required');
        } else {

            document.getElementById('modal-close').click();

            showLoader();
            let res = await axios.post("/CategoryUpdate", {
                name: categoryName,
                id: updateId
            })
            hideLoader();

            if (res.status === 200 && res.data === 1) {
                successToast('Updated Successfully');
                document.getElementById("updateForm").reset();
                await getAllCategory();
            } else {
                errorToast("Request fail !")
            }
        }
    }
</script>
