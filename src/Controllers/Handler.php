<?php
namespace IgniterWire\Controllers;

use CodeIgniter\Controller;

class Handler extends Controller
{
    public function handle()
    {
        $request = service('request');
        $data = $request->getJSON(true);
        $component = $data['component'] ?? null;
        $method = $data['method'] ?? null;
        $params = $data['params'] ?? [];
        $class = 'App\\IgniterWire\\Components\\' . ucfirst($component);
        if (!class_exists($class) || !$method) {
            return $this->response->setJSON(['html' => '<div style="color:red">Component veya method bulunamadı</div>']);
        }
        $instance = new $class();
        $instance->beforeMount();
        $instance->mount();
        $instance->afterMount();
        // Methodu çağır
        if (method_exists($instance, $method)) {
            call_user_func_array([$instance, $method], $params);
        }
        // State'i view'a aktar
        $view = 'igniterwire/components/' . strtolower($component);
        $data = $instance->getViewData();
        $data['component'] = $instance;
        $html = function_exists('view') ? view($view, $data) : '';
        return $this->response->setJSON([
            'html' => $html,
            'state' => $instance->getViewData()
        ]);
    }
}
