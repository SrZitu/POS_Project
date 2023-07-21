<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <div class="text-center">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                        alt="Avatar" class="img-fluid mb-3" style="width: 80px; " />
                    </div>
                    <h4 class="text-color">ENTER OTP CODE</h4>
                    <br />
                    <label class="text-color">4 Digit Code Here</label>
                    <input id="code" placeholder="Code" class="form-control" type="text" />
                    <br />
                    <button onclick="VerifyOtp()" class="btn w-100 float-end gradient-custom text-white">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function VerifyOtp() {

        let code = document.getElementById('code').value;
        if (code.length !== 4) {
            errorToast("4 Digit Verification Code Required !");
        } else {
            let res = await axios.post("/Verify-Otp", {
                otp: code,
                email: sessionStorage.getItem('email')
            })
            if (res.status === 200) {
                successToast(res.data['message']);
                sessionStorage.clear();
                setTimeout(() => {
                    window.location.href = "/resetPassword";
                }, 2000);

            } else {
                errorToast("Something Went Wrong !")
            }
        }
    }
</script>
