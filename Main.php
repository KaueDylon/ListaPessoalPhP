<?php

include "entity/UsuarioEntity.php";
include "repository/UsuarioRepository.php";
include "Database.php";
include "Menu.php";
include "exceptions/PaginacaoException.php";
include "exceptions/IdNaoEncontratoException.php";


$usuarioRepository = new UsuarioRepository(Database::getConnection());

$menu = new Menu(
    new UsuarioRepository(Database::getConnection())
);

$menu->menu($usuarioRepository);