<?php
class AuthMiddleware
{
    public function check($role, $controller, $action)
    {
        // Các controller và method không cho phép truy cập nếu role khác 1 (admin)
        $permissions = [
            'Products' => ['index'],
            'Categories' => ['index'],
            'Users' => ['index'],
        ];

        // Kiểm tra quyền hạn người dùng
        $controllerName = is_object($controller) ? get_class($controller) : $controller;
        $actionName = is_string($action) ? $action : '';

        // Thêm dòng log để kiểm tra giá trị
        error_log("Controller: $controllerName, Action: $actionName");

        if (isset($permissions[$controllerName])) {
            if (in_array($actionName, $permissions[$controllerName])) {
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role) {
                    return true;
                }
                return false;
            }
            return true;
        }
        return true;
    }
}
