<?php require_once __DIR__ . '/headers/head.php'; ?>
<body>

<div class="container">
<content>
    <div class=login-content>


        <div class="loginPage-logo">
            <div class="message">
<?php           if (isset($messages)) foreach ($messages as $m)  print $m;   ?>
            </div>
        </div>

        <div class="login-right" >
            <div style="background-color: #fff;">
                <form action="login" method="post" id="login-form">
                    <input name="login" type="text" placeholder="Login">
                    <input name="password" type="password" placeholder="Password">
                    <button type="submit">LOGIN</button>

                </form>
            </div>
            <div class="register-href">
                <p>Nie masz jeszcze konta ?</p> <a href="register">zarejestruj sie</a>
            </div>
        </div>


    </div>


</content>

<?php require_once __DIR__ . '/static/footer.php';   ?>
</div> <!-- </div container>-->
</body>
</html>