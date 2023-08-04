<div class="modal .custom-modal" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Update Product</h4>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mx-3">
                <form id="updateForm">
                    <div class="container">
                        <div class="row">

                            <div class="col-12 p-1">
                                <div class="md-form mb-2">
                                    <label class="form-label">Category</label>
                                    <select type="text" class="form-control form-select" id="productCategoryUpdate">
                                        <option value="">Select Category</option>
                                    </select>
                                </div>

                                <div class="md-form mb-2">
                                    <i class="fas fa-list-alt prefix grey-text"></i>
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="productNameUpdate">
                                </div>
                                <div class="md-form mb-2">
                                    <i class="fas fa-money-bill-wave prefix grey-text"></i>
                                    <label class="form-label">Price</label>
                                    <input type="text" class="form-control" id="productPriceUpdate">
                                </div>
                                <div class="md-form mb-2">
                                    <i class="fas fa-sort-amount-up"></i>
                                    <label class="form-label">Unit</label>
                                    <input type="text" class="form-control" id="productUnitUpdate">
                                </div>
                                <div class="md-form mb-2">
                                    <label class="form-label">Image</label>
                                    <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])" type="file"
                                        class="form-control" id="productImgUpdate">
                                </div>
                                <br />
                                <img class="w-20" id="oldImg" src="{{ asset('images/noimage.jpg') }}" />
                                <br />

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="filePath">
                            </div>
                        </div>
                </form>
            </div>


            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm deleteBtn" data-bs-dismiss="modal">Close</button>
                <button onclick="update()" id="update-btn" class="btn btn-sm custom-btn">Update</button>
            </div>
        </div>
    </div>

</div>
</div>

<script>
    async function updateCategoryDropDown() {
        let response = await axios.get('/CategoryList');
        response.data.forEach((item, index) => {
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $('#productCategoryUpdate').append(option);
        });
    }

    async function fillUpUpdateForm(id, filePath) {
        document.getElementById('updateID').value = id;
        document.getElementById('filePath').value = filePath;
        document.getElementById('oldImg').src = filePath;

        showLoader();

        await updateCategoryDropDown();
        let response = await axios.post('/ProductId', {
            id: id
        })
        hideLoader();

        document.getElementById('productCategoryUpdate').value = response.data['category_id'];
        document.getElementById('productNameUpdate').value = response.data['name'];;
        document.getElementById('productPriceUpdate').value = response.data['price'];;
        document.getElementById('productUnitUpdate').value = response.data['unit'];;
    }


    async function update() {

        let productCategoryUpdate = document.getElementById('productCategoryUpdate').value;
        let productNameUpdate = document.getElementById('productNameUpdate').value;
        let productPriceUpdate = document.getElementById('productPriceUpdate').value;
        let productUnitUpdate = document.getElementById('productUnitUpdate').value;
        let productImgUpdate = document.getElementById('productImgUpdate').files[0];
        let updateID = document.getElementById('updateID').value
        let filePath = document.getElementById('filePath').value

        if (productNameUpdate.length === 0) {
            errorToast('Product Name is Required');
        } else if (productCategoryUpdate.length === 0) {
            errorToast('Product Category is Required');
        } else if (productPriceUpdate.length === 0) {
            errorToast('Product Price is Required');
        } else if (productUnitUpdate.length === 0) {
            errorToast('Product Unit is Required');
        } else {

            document.getElementById('update-modal-close').click();

            let formData = new FormData();
            formData.append('img', productImgUpdate)
            formData.append('name', productNameUpdate)
            formData.append('price', productPriceUpdate)
            formData.append('unit', productUnitUpdate)
            formData.append('category_id', productCategoryUpdate)
            formData.append('id', updateID)
            formData.append('filePath', filePath)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();

            try {
                let res = await axios.post("/UpdateProduct", formData, config);

                hideLoader();

                if (res.status === 200 && res.data===1) {
                    successToast('Product Updated Successfully');
                    document.getElementById("updateForm").reset();
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
