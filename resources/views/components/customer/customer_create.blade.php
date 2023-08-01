<div class="modal .custom-modal" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="createForm">
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
                        <input type="text" class="form-control" id="customerName">
                    </div>
                    <div class="md-form mb-5">
                        <i class="fas fa-list-alt prefix grey-text"></i>
                        <label class="form-label">Customer Email</label>
                        <input type="text" class="form-control" id="customerEmail">
                    </div>
                    <div class="md-form mb-5">
                        <i class="fas fa-list-alt prefix grey-text"></i>
                        <label class="form-label">Customer Mobile Number</label>
                        <input type="text" class="form-control" id="customerMobile">
                    </div>


                    <div class="modal-footer">
                        <button id="modal-close" class="btn btn-sm custom-btn" data-bs-dismiss="modal">Close</button>
                        <button onclick="store()" id="save-btn" class="btn btn-sm custom-btn">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    async function store() {

        let customerName = document.getElementById('customerName').value;
        let customerEmail = document.getElementById('customerEmail').value;
        let customerMobile = document.getElementById('customerMobile').value;

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
                let res = await axios.post("/create-Customers", {
                    name: customerName,
                    email: customerEmail,
                    mobile: customerMobile
                });
                hideLoader();

                if (res.status === 201) {
                    successToast('Request Successful');
                    document.getElementById("createForm").reset();
                    await getAllCustomer();
                } else {
                    errorToast("Request fail !");
                }
            } catch (error) {
                errorToast("An error occurred. Please try again.");
            }
        }
    }
</script>
