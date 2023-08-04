<div class="modal .custom-modal" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Add Product</h4>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mx-3">
                <form id="createForm">
                    <div class="container">
                        <div class="row">

                            <div class="col-12 p-1">
                                <div class="md-form mb-2">
                                    <label class="form-label">Category</label>
                                    <select type="text" class="form-control form-select" id="productCategory">
                                        <option value="">Select Category</option>
                                    </select>
                                </div>

                                <div class="md-form mb-2">
                                    <i class="fas fa-list-alt prefix grey-text"></i>
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="productName">
                                </div>
                                <div class="md-form mb-2">
                                    <i class="fas fa-money-bill-wave prefix grey-text"></i>
                                    <label class="form-label">Price</label>
                                    <input type="text" class="form-control" id="productPrice">
                                </div>
                                <div class="md-form mb-2">
                                    <i class="fas fa-sort-amount-up"></i>
                                    <label class="form-label">Unit</label>
                                    <input type="text" class="form-control" id="productUnit">
                                </div>
                                <div class="md-form mb-2">
                                    <label class="form-label">Image</label>
                                    <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file"
                                        class="form-control" id="productImg">
                                </div>
                                <br />
                                <img class="w-20" id="newImg" src="{{ asset('images/noimage.jpg') }}" />
                                <br />

                            </div>
                        </div>
                </form>
            </div>


            <div class="modal-footer">
                <button id="modal-close" class="btn btn-sm deleteBtn" data-bs-dismiss="modal">Close</button>
                <button onclick="store()" id="save-btn" class="btn btn-sm custom-btn">Save</button>
            </div>
        </div>
    </div>

</div>
</div>

<script>
    fillCategory();
    async function fillCategory() {
        let response = await axios.get('/CategoryList');
        response.data.forEach((item, index) => {
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $('#productCategory').append(option);
        });
    }

    async function store() {

        let productCategory = document.getElementById('productCategory').value;
        let productName = document.getElementById('productName').value;
        let productPrice = document.getElementById('productPrice').value;
        let productUnit = document.getElementById('productUnit').value;
        let productImg = document.getElementById('productImg').files[0];


        if (productName.length === 0) {
            errorToast('Product Name is Required');
        } else if (productCategory.length === 0) {
            errorToast('Product Category is Required');
        } else if (productPrice.length === 0) {
            errorToast('Product Price is Required');
        } else if (productUnit.length === 0) {
            errorToast('Product Unit is Required');
        } else if (!productImg) {
            errorToast('Product image is Required');
        } else {

            document.getElementById('modal-close').click();

            let formData=new FormData();
            formData.append('img', productImg)
            formData.append('name', productName)
            formData.append('price', productPrice)
            formData.append('unit', productUnit)
            formData.append('category_id', productCategory)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            try {
                let res = await axios.post("/CreateProduct", formData, config);
                console.log(res);
                hideLoader();

                if (res.status === 201) {
                    successToast('Product Added Successfully');
                    document.getElementById("createForm").reset();
                    await getAllProduct();
                } else {
                    errorToast("Request fail !");
                }
            } catch (error) {
                errorToast("An error occurred. Please try again.");
            }
        }
    }
</script>
