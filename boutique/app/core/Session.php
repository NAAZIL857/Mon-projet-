<?php
/**
 * Classe Session - Gestion des sessions utilisateur et sécurité
 */

class Session {
    
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    public static function remove($key) {
        unset($_SESSION[$key]);
    }

    public static function destroy() {
        session_destroy();
    }

    public static function isLoggedIn() {
        return self::has('user_id');
    }

    public static function isAdmin() {
        return self::get('user_role') === 'admin';
    }

    public static function getUserId() {
        return self::get('user_id');
    }

    public static function login($user) {
        self::set('user_id', $user['id']);
        self::set('user_name', $user['nom']);
        self::set('user_role', $user['role']);
        self::set('user_email', $user['email']);
    }

    public static function logout() {
        session_unset();
        session_destroy();
    }

    public static function generateCSRF() {
        $token = bin2hex(random_bytes(32));
        self::set(CSRF_TOKEN_NAME, $token);
        return $token;
    }

    public static function validateCSRF($token) {
        return hash_equals(self::get(CSRF_TOKEN_NAME), $token);
    }

    public static function getCSRF() {
        return self::get(CSRF_TOKEN_NAME);
    }
}
?>