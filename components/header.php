<?php

$firstName = $_SESSION['user']['userFirstName'];
$userfullname = $firstName . " " . $_SESSION['user']['userLastName'];
echo <<<HTML
<header class="fixed z-10 w-full">
    <nav class="navbar navbar-top-academia flex items-center">
        <div class="nav-container w-full">
            <a class="" href="./home.php">
                <figure>
                    <img class="" src="/img/logo-name.png" alt="Cetisi" />
                    <figcaption class="cetisi-community-badge">Academia</figcaption>
                </figure>
            </a>
            <div class="menu">
                <div class="mr-auto pl-3">
                    <ul>
                        <li class="nav-item-divider pr-1"></li>
                        <li><a href="./home.php">Inicio</a></li>
                    </ul>
                </div>
                <div class="ml-auto">
                    <ul>
                        <li><a href="/view/info.php"><ion-icon name="information-circle-sharp"></ion-icon></a></li>
                        <li class="nav-item-divider p-2"></li>
                        <li id="dropdown-trigger" class="relative">
                            <ion-icon name="person"></ion-icon>
                            <div class="user-dropdown absolute hidden" style="width: 200px; background: #fff;">
                                <div class="dropdown-arrow"></div>
                                <div class="flex flex-col p-5">
                                    <h1>$userfullname</h1>
                                    <a style="color: #6938ef;" href="/view/profile.php">Editar perfil</a>
                                </div>
                                <div class="px-5 py-3">
                                    <a href="/view/info.php">Info</a>
                                </div>
                                <div class="p-5">
                                    <a style="color: #6938ef;" href="/controller/logout.php">Cerrar Sesión</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
HTML;