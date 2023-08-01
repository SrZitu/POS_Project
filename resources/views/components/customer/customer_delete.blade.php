<div class="modal .custom-modal" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 450px;">
            <div class="modal-title text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteID"/>
            </div>
            <div class="modal-body mx-3 ">
                <div class="modal-footer flex justify-content-center align-content-center">
                    <button type="button" id="delete-modal-close" class="btn shadow-sm custom-btn" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn shadow-sm btn-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

     async  function  itemDelete(){
            let id=document.getElementById('deleteID').value;
            document.getElementById('delete-modal-close').click();
            showLoader();
            let res=await axios.post("/customerDelete",{id:id})
            hideLoader();
            if(res.data===1){
                successToast("Deleted Successfully")
                await  getAllCustomer();
            }
            else{
                errorToast("Request fail!")
            }
     }

</script>
