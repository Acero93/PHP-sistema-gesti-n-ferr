

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="modelo/css/estilos.css">
    <!-- Title Page -->  
    <title>Login</title>
 
    <!-- CSS -->

</head>
<body class="d1">
    <div id="container">
        <form action="" method="POST">
            <?php 

                if(isset($errorLogin)){
                    echo $errorLogin;
                }
            ?>

            <div class="login-page">
            <div class="fo">

                <form class="login-form">
                        <label style="  color: black;" for="username">Nombre de usuario</label>                      
                    <div class="row">
                        <input class="inp" type="text" name="username" >
                    </div>
                        <label style=" color: black;" for="password">Contraseña</label>
                    <div class="row">

                    <!-- <p><a href="#">Forgot your password?</a> -->
                           <input class="inp" type="password" name="password">
                    </div>
                    <button class="but1 but2" type="submit" value="INGRESAR" >login</button>
                </form>
            </div>
            </div>

            <div class="row center">


                    <div id="lower">
                                <!-- <input type="checkbox"><label class="check" for="checkbox">Keep me logged in</label> -->
                                <!-- Submit Button -->
                                <!-- <input class="center" type="submit" value="INGRESAR"> -->
                    </div>


            </div>
        </form>       
    </div>
</body>
</html>


