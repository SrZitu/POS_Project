<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4 mt-2">
                <div class="card-body ">
                    <div class="text-center">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                        alt="Avatar" class="img-fluid mb-3" style="width: 80px; " />
                    </div>

                    <h4 class="text-color">SIGN IN</h4>
                    <br/>
                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                    <br/>
                    <input id="pass" placeholder="User Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="SubmitLogin()" class="btn w-100 gradient-custom text-white ">Next</button>
                    <hr/>
                    <div class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6 text-color " href="{{url('/userRegistration')}}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6 text-color" href="{{url('/sendOtp')}}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

async function SubmitLogin() {
    let email = document.getElementById('email').value;
    let pass = document.getElementById('pass').value;
    if (email.length === 0) {
        errorToast('Email Required!');
    } else if (pass.length === 0) {
        errorToast('Password Required!');
    } else {
        showLoader();
        try {
            let res = await axios.post("/User-Login", { email: email, password: pass });
            if (res.status === 200) {
                successToast("Login Successful");
                window.location.href = "/dashboard";
            } else {
                errorToast("Invalid User or Password");
            }
        } catch (error) {
            errorToast("Error occurred during login");
        } finally {
            hideLoader();
        }
    }
}

</script>
