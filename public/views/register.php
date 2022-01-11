<?php
require_once __DIR__ . '/headers/head.php';
?>
<body>
<content>

    <div class=login-content>
        <div class="loginPage-logo">
            <div class="message">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $m) {
                        print $m;
                    }
                }
                ?>
            </div>
            <img src="../img/logo.png">
        </div>

        <div class="login-right">


            <a href = "/">Wróć do strony logowania</a>
            <form class="adding" action="registerTeacher" method="post">
                <?php
                if (isset($messages))
                    foreach ($messages as $message)
                        echo $message;
                ?>
                <input name="Name" type="text" class="regInput" placeholder="Imię">
                <input name="Surname" type="text" class="regInput" placeholder="Nazwisko">
                <input name="Email" type="text" class="regInput" placeholder="Adres email">
                <input name="Username" type="text" class="regInput" placeholder="Nazwa Użytkownika">
                <input name="Password" type="password" class="regInput" placeholder="Hasło">
                <!--dodac inputa z wyborem konta -->


                    <button class="buttNext">
                        Zarejestruj
                    </button>

            </form>

        </div>
    </div>
</content>
<?php require_once __DIR__ . '/public/views/static/footer.php'; ?>


</body>
</html>
