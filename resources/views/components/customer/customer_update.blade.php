<div class="modal .custom-modal" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="updateform">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Create Category</h4>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i class="fas fa-list-alt prefix grey-text"></i>
                        <label class="form-label">Customer Name</label>
                        <input type="text" class="form-control" id="updateCustomerName">
                        <input class="d-none" id="updateId">
                    </div>
                    <div class="md-form mb-5">
                        <i class="fas fa-list-alt prefix grey-text"></i>
                        <label class="form-label">Customer Email</label>
                        <input type="text" class="form-control" id="UpdatecustomerEmail">
                    </div>
                    <div class="md-form mb-5">
                        <i class="fas fa-list-alt prefix grey-text"></i>
                        <label class="form-label">Customer Mobile Number</label>
                        <input type="text" class="form-control" id="UpdatecustomerMobile">
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
    try {
        showLoader();
        const response = await axios.post('/CustomerId', {
            id: id
        });
        hideLoader();
        document.getElementById('updateCustomerName').value = response.data['name'];
        document.getElementById('UpdatecustomerEmail').value = response.data['email'];
        document.getElementById('UpdatecustomerMobile').value = response.data['mobile'];
    } catch (error) {
        console.error(error);
        errorToast("An error occurred while fetching customer data.");
    }
}

    async function update() {

        let customerName = document.getElementById('updateCustomerName').value;
        let customerEmail = document.getElementById('UpdatecustomerEmail').value;
        let customerMobile = document.getElementById('UpdatecustomerMobile').value;
        let updateId = document.getElementById('updateId').value;

        if (customerName.length === 0) {
            errorToast('Customer Name is Required');
        } else if (customerEmail.length === 0) {
            errorToast('Customer Email is Required');
        } else if (customerMobile.length === 0) {
            errorToast('Customer Mobile number is Required');
        } else {

            document.getElementById('modal-close').click();

            showLoader();
            try {
                let res = await axios.post("/customerUpdate", {
                    name: customerName,
                    email: customerEmail,
                    mobile: customerMobile,
                    id:updateId
                });
                hideLoader();

                if (res.status === 200) {
                    successToast('Request Successful');
                    document.getElementById("updateform").reset();
                    await getAllCustomer();
                } else {

                    errorToast("Request fail !");
                }
            } catch (error) {
                console.error(error);
                errorToast("An error occurred. Please try again.");
            }
        }
    }
</script>
