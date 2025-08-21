<?php
if (!function_exists('igniterwire')) {
    function igniterwire($component, $params = []) {
        $class = 'App\\IgniterWire\\Components\\' . ucfirst($component);
        if (!class_exists($class)) {
            return '<div style="color:red">Component bulunamadı: ' . htmlspecialchars($component) . '</div>';
        }
        $instance = new $class();
        $instance->beforeMount();
        call_user_func_array([$instance, 'mount'], $params);
        $instance->afterMount();
        $view = 'igniterwire/components/' . strtolower($component);
        $data = $instance->getViewData();
        // View dosyasına component referansı da gönder
        $data['component'] = $instance;
        $html = view($view, $data);
        // igniter-component attribute'u ile sarmala
        return '<div igniter-component="' . htmlspecialchars($component) . '">' . $html . '</div>';
    }
}
