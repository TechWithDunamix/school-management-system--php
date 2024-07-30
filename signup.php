<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>AKKHOR | Signup</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="css/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="css/all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="fonts/flaticon.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Modernize js -->
    <script src="js/modernizr-3.6.0.min.js"></script>
    <style>
        #loader {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        #loader img {
            width: 50px;
            height: 50px;
        }
        .button-loader {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
        }
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <!-- Signup Page Start Here -->
    <div class="login-page-wrap">
        <div class="login-page-content">
            <div id="loader">
                <img src="img/loader.gif" alt="Loading...">
            </div>
            <div class="login-box">
                <div class="item-logo">
                    <img src="img/logo2.png" alt="logo">
                </div>
                <form action="" class="login-form" method="POST" id='login-form'>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" placeholder="Enter Full Name" class="form-control" name="username">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="form-group">
                        <label>School Name</label>
                        <p id="school_name-error" style="color: red;"></p>
                        <input type="text" placeholder="Enter School Name" class="form-control" name="school_name">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <p id="email-error" style="color: red;"></p>
                        <input type="email" placeholder="Enter email" class="form-control" name="email">
                        <i class="far fa-envelope"></i>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" placeholder="Enter password" class="form-control" name="password">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="login-btn" id="submit-button">Signup</button>
                    </div>
                </form>
            </div>
            <div class="sign-up">Already have an account ? <a href="login.html">Login now!</a></div>
        </div>
    </div>
    <!-- Signup Page End Here -->
    <!-- jquery-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Scroll Up Js -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- Custom Js -->
    <script src="js/main.js"></script>
</body>

<script type="module">
    $("#login-form").on("submit", (e) => {
        e.preventDefault();
        $("#email-error").html('');
        $("#school_name-error").html('');
        
        // Disable all form fields and button
        $("input").addClass("disabled").attr("disabled", true);
        $("#submit-button").addClass("disabled").attr("disabled", true).append('<div class="button-loader"></div>');

        const formData = {
            username: $("input[name='username']").val(),
            school_name: $("input[name='school_name']").val(),
            email: $("input[name='email']").val(),
            password: $("input[name='password']").val()
        };

        $.ajax({
            url: 'backend/signup.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(response) {
                $("#submit-button").find('.button-loader').remove();
                $("input").removeClass("disabled").attr("disabled", false);
                $("#submit-button").removeClass("disabled").attr("disabled", false);
                window.location.href = 'index.php';
            },
            error: function(error) {
                $("#submit-button").find('.button-loader').remove();
                $("input").removeClass("disabled").attr("disabled", false);
                $("#submit-button").removeClass("disabled").attr("disabled", false);
                
                try {
                    const errorResponse = JSON.parse(error.responseText);
                    $("#email-error").html(errorResponse.email);
                    $("#school_name-error").html(errorResponse.school_name);
                } catch (e) {
                    console.error("Failed to parse error response:", e);
                    console.error(error.responseText);
                }
            }
        });
    });
</script>
</html>
