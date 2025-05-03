<?php
require_once __DIR__ . '/Usuario.php';

class Auth {
    public static function iniciarSessao($usuario) {
        if (session_status() !== PHP_SESSION_ACTIVE)
        session_start();
        $_SESSION['usuario_id'] = $usuario->getId();
        $_SESSION['usuario_email'] = $usuario->getEmail();
        $_SESSION['usuario_nome'] = $usuario->getNome();
        $_SESSION['logado'] = true;
    }

    public static function verificarSessao() {
        if (session_status() !== PHP_SESSION_ACTIVE)
        session_start();
        if (!isset($_SESSION['logado']) || !$_SESSION['logado']) {
            header('Location: login.php');
            exit();
        }
    }

    public static function destruirSessao() {
        if (session_status() !== PHP_SESSION_ACTIVE)
        session_start();
        session_unset();
        session_destroy();
    }

    public static function getUsuarioLogado() {
        if (session_status() !== PHP_SESSION_ACTIVE)
        session_start();
        if (isset($_SESSION['logado'])) {
            $usuario = new Usuario();
            $usuario->carregar($_SESSION['usuario_id']);
            return $usuario;
        }
        return null;
    }
}