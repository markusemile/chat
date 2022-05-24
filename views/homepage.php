
<div class="container w-full">
    <div id="alert-container" style="min-height:10vh">

    </div>
    <div class="row mx-auto  mx-auto gap-4 mt-5 align-items-center justify-content-center mb-5">
        <div class="signin-container col-sm-12 col-md-4">
            <div class="card bg-danger p-5 text-dark">
                <h2 class="fw-bold mx-auto">Sign In</h2>
                <form action="http://myiptest.be/chatbox" method="post"  id="signinForm" name="signinForm" class="flex flex-column" >
                    <div class="form-group ">
                        <input id="usernameSignin" class="username form-control" name="username" type="text" autoComplete='off' required />
                        <input id="token"  name="token" type="hidden" autoComplete='off' />
                        <input id="id"  name="id" type="hidden" autoComplete='off' />
                        <label htmlFor="usernameSignin" class="label-form fw-light ">User name </label>
                    </div>
                    <div class="form-group ">
                        <input id="passwordSignin" class="password form-control" name="password" type="password" autoComplete='off' required />
                        <label htmlFor="passwordSignin" class="label-form fw-light ">password </label>
                    </div>
                    <div class="button text-center pt-3">
                        <button type='submit' class='btn btn-info' ">Go to chat !</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-1 text-light">
            <h1>OR</h1>
        </div>
        <div class="signup-container col-sm-12 col-md-4  ">
            <div class="card bg-danger p-5 text-dark">
                <h2 class="fw-bold mx-auto">Sign Up</h2>
                <form action="http://myiptest.be/chatbox" method="post"  id="signupForm" name="signupForm" class="flex flex-column" ">
                    <div class="form-group ">
                        <input id="usernameSignup" name="username" class="username form-control" name="username" type="text" autoComplete='off' required />
                        <label htmlFor="usernameSignup" class="label-form fw-light ">User name </label>
                        <input id="token"  name="token" type="hidden" autoComplete='off' />
                        <input id="id"  name="id" type="hidden" autoComplete='off' />
                    </div>
                    <div class="form-group ">
                        <input id="passwordSignup" name="password" class="password form-control" type="password" autoComplete='off' required/>
                        <label htmlFor="passwordSignup" class="label-form fw-light ">password </label>
                    </div>
                    <div class="form-group ">
                        <input id="confirmPassword" name="confirmPassword" class="password form-control" type="password" autoComplete='off' required />
                        <label htmlFor="confirmPassword" class="label-form fw-light ">Confirm password </label>
                    </div>
                    <div class="button text-center pt-3">
                        <button type='submit' class='btn btn-info'>Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload=function(){
        // const getDatas = setInterval(()=>{
        //     getMessages();
        //     getConnectedUsers(sessionStorage.id)
        // },2000);
        // getDatas();

        signInForm = document.getElementById('signinForm');
        signInForm.addEventListener('submit',function(evt){
            evt.preventDefault();
            signin(signinForm);
        });

        signUpForm = document.getElementById('signupForm');
        signUpForm.addEventListener('submit',function(evt){
            evt.preventDefault();
            signup(signupForm);
        });
    }
</script>