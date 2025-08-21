if (!function_exists('igniter_text')) {
    function igniter_text($value) {
        return htmlspecialchars((string)$value);
    }
}

if (!function_exists('igniter_if')) {
    function igniter_if($condition, $true, $false = '') {
        return $condition ? $true : $false;
    }
}

if (!function_exists('igniter_foreach')) {
    function igniter_foreach($array, $callback) {
        $result = '';
        foreach ($array as $key => $value) {
            $result .= $callback($value, $key);
        }
        return $result;
    }
}
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
    // igniter-component attribute'u ile sarmala ve state'i JS için ekle
    $stateJson = htmlspecialchars(json_encode($instance->getViewData()), ENT_QUOTES, 'UTF-8');
    return '<div igniter-component="' . htmlspecialchars($component) . '" data-igniter-state="' . $stateJson . '">' . $html . '</div>';
    }
}
