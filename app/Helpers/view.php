<?php

use Core\Application;
use Core\Config\ConfigManager;

if (! function_exists('app')) {
    function app(): Application
    {
        global $app;

        return $app;
    }
}

if (! function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        return dirname(__DIR__, 2) . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/\\') : '');
    }
}

if (! function_exists('config')) {
    function config(
        string $key,
        mixed $default = null
    ): mixed {
        return app()
            ->config()
            ->get($key, $default);
    }
}

if (! function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? null;

        if ($value === null) {
            return $default;
        }

        return match (strtolower($value)) {
            'true' => true,
            'false' => false,
            'null' => null,
            default => $value,
        };
    }
}

if (! function_exists('e')) {
    /**
     * Escape string values for XSS protection.
     *
     * @param string|null $value
     * @return string
     */
    function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (! function_exists('session_flash')) {
    /**
     * Set a flash message in the session.
     */
    function session_flash(string $key, mixed $value): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['_flash'][$key] = $value;
    }
}

if (! function_exists('session_get_flash')) {
    /**
     * Get a flash message and clear it from session.
     */
    function session_get_flash(string $key, mixed $default = null): mixed
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['_flash'][$key])) {
            $val = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $val;
        }

        return $default;
    }
}

if (! function_exists('render_toaster')) {
    /**
     * Render SweetAlert2 / Toastr notification for session flash messages.
     */
    function render_toaster(): void
    {
        $error = session_get_flash('error');
        $errors = session_get_flash('errors');
        $success = session_get_flash('success');

        $messages = [];
        if ($error) {
            $messages[] = is_array($error) ? implode('<br>', $error) : $error;
        }

        if ($errors && is_array($errors)) {
            foreach ($errors as $fieldErrors) {
                if (is_array($fieldErrors)) {
                    $messages = array_merge($messages, $fieldErrors);
                } else {
                    $messages[] = $fieldErrors;
                }
            }
        }

        if (!empty($messages)) {
            $joinedMsg = implode('<br>', array_map('e', $messages));
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'خطأ في البيانات',
                            html: '{$joinedMsg}',
                            showConfirmButton: false,
                            timer: 6000,
                            timerProgressBar: true
                        });
                    }
                });
            </script>";
        }

        if ($success) {
            $cleanSuccess = e((string)$success);
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'تمت العملية بنجاح',
                            text: '{$cleanSuccess}',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true
                        });
                    }
                });
            </script>";
        }
    }
}

if (! function_exists('csrf_token')) {
    function csrf_token(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_csrf_token'];
    }
}

if (! function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}

if (! function_exists('view')) {
    function view(string $path, array $data = []): void
    {
        extract($data);

        require base_path("resources/views/{$path}.php");
    }
}