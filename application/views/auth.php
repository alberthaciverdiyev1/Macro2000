<div id="login">
    <h3 class="text-center text-white pt-5">Login form</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                        <h3 class="text-center text-info">Login</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Username:</label><br>
                            <input type="text" name="" id="login-username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label><br>
                            <input type="text" name="" id="login-password" class="form-control">
                        </div>
                        <button class="bg-info w-50 mx-auto" id="login-btn">Login</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="register">
    <h3 class="text-center text-white pt-5">Register form</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                        <h3 class="text-center text-info">Register </h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Username:</label><br>
                            <input type="text" name="username" id="register-username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label><br>
                            <input type="text" name="password" id="register-password" class="form-control">
                        </div>
                        <div id="register-link" class="text-right">
                            <p data-role="login" class="text-info">Login here</p>
                        </div>
                        <button class="bg-info w-50 mx-auto" id="register-btn">Register</button>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', `#register-btn`, () => {
        let data = {
            username: $('#register-username').val(),  
            password: $('#register-password').val()  
        };
        console.log({data});

        $.post({
            url: 'http://localhost/ci3_project/index.php/register',  
            method: 'POST',
            data: data, 
            success: (response) => {
                data = {}
                Swal.fire({
          title: "Success",
          icon: "success"
        });            },
            error: (e) => {
                console.log(e); 
            }
        });
    });

    $(document).on('click', `#login-btn`, () => {
        let data = {
            username: $('#login-username').val(),
            password: $('#login-password').val()
        };
        console.log({data});
        
        $.post({
            url: 'http://localhost/ci3_project/index.php/login',  
            method: 'POST',
            data: data,
            success: (d) => {
                data = {}
                let response = JSON.parse(d);
                console.log(response);

                if (response.user.role === "admin") {
                    window.location.href = "http://localhost/ci3_project/index.php/task-list"; 
                }else{
                    window.location.href = "http://localhost/ci3_project/index.php/customer-request"; 
                }
            },
            error: (e) => {
                console.log(e);
            }
        });
    });
</script>
