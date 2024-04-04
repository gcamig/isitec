<?php
echo <<<HTML
<header class="fixed z-10 w-full">
    <nav class="navbar navbar-top-academia">
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
                        <li><a href="./user_space.php">Mi academia</a></li>
                        <li><a href="./catalog.php">Cursos</a></li>
                    </ul>
                </div>
                <div class="ml-auto">
                    <ul>
                        <li><ion-icon name="information-circle-sharp" style="font-size:30px;"></ion-icon></li>
                        <li class="nav-item-divider p-2"></li>
                        <li id="dropdown-trigger" class="relative">
                            <ion-icon name="person"></ion-icon>
                            <div class="user-dropdown absolute hidden" style="width: 200px; background: #fff;">
                                <div class="dropdown-arrow"></div>
                                <div class="flex flex-col p-5">
                                    <h4>Username</h4>
                                    <small><a style="color: #6938ef;" href="profile">Editar perfil</a></small>
                                </div>
                                <div class="px-5 py-3">
                                    <a href="support">Centro de ayuda</a>
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