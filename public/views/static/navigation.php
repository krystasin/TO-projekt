<header class="header">

    <nav class="navbar">
        <ul class="navUl">
            <li class="navLi"><a href="stronaGlowna"> strona Główna </a></li>
            <li class="navLi"><a href="scrape"> scrape  </a></li>
            <li class="navLi"><a href="curl"> curl  </a></li>
        </ul>
    </nav>
    <div class="nav-user">
        <ul>
            <li class="userLi"><a href="logout"><?php if(isset($_SESSION['user'])) echo $_SESSION['user'];?></a></li>
        </ul>
    </div>

</header>

