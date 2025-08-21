<?php
namespace IgniterWire;

use CodeIgniter\Config\BaseService;

class ServiceProvider extends BaseService
{
    public static function register()
    {
        // Spark komutunu kaydet
        if (class_exists('CodeIgniter\\CLI\\Commands')) {
            \CodeIgniter\CLI\Commands::add('igniterwire:make-component', \IgniterWire\Commands\MakeComponent::class);
        }
    }
}
