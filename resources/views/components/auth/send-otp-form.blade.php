<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <div class="text-center">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                        alt="Avatar" class="img-fluid mb-3" style="width: 80px; " />
                    </div>
                    <h4 class="text-color">EMAIL ADDRESS</h4>
                    <br />
                    <label class="text-color">Your email address</label>
                    <input id="email" placeholder="User Email" class="form-control" type="email" />
                    <br />
                    <button onclick="VerifyEmail()" class="btn w-100 float-end  gradient-custom text-white">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function VerifyEmail() {
        let email = document.getElementById('email').value;
        if (email.length === 0) {
            errorToast("Email Address Required!");
        } else {
            showLoader();
            let res = await axios.post("/Send-OtpToEmail", {
                email: email
            });
            hideLoader();
            if (res.status === 200) {
                successToast(res.data['message']);
                sessionStorage.setItem('email', email);
                setTimeout(() => {
                    window.location.href = "/verifyOtp"
                }, 2000);

            } else {
                errorToast("Email Not Found")
            }

        }
    }
</script>
