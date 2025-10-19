<?php
namespace IgniterWire\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeComponent extends BaseCommand
{
    protected $group       = 'IgniterWire';
    protected $name        = 'igniterwire:make-component';
    protected $description = 'Yeni bir IgniterWire component oluşturur';
    protected $usage       = 'igniterwire:make-component <ComponentName>';
    protected $arguments   = [
        'ComponentName' => 'Oluşturulacak componentin adı.'
    ];

    public function run(array $params)
    {
        $name = $params[0] ?? null;
        if (!$name) {
            CLI::error('Component adı belirtmelisiniz.');
            return;
        }
        $className = ucfirst($name);
        $lowerName = strtolower($name);
        $componentDir = APPPATH . 'IgniterWire/Components/';
        if (!is_dir($componentDir)) {
            mkdir($componentDir, 0777, true);
        }
        $componentPath = $componentDir . $className . '.php';
        if (file_exists($componentPath)) {
            CLI::error('Bu isimde bir component zaten var.');
            return;
        }
        $template = "<?php\nnamespace App\\IgniterWire\\Components;\n\nuse IgniterWire\\Component;\n\nclass $className extends Component\n{\n    public function render()\n    {\n        return view('igniterwire/components/$lowerName');\n    }\n}\n";
        file_put_contents($componentPath, $template);
        // View dosyası
        $viewDir = APPPATH . 'Views/igniterwire/components/';
        if (!is_dir($viewDir)) {
            mkdir($viewDir, 0777, true);
        }
        $viewPath = $viewDir . strtolower($name) . '.php';
        file_put_contents($viewPath, "<div>\n    <!-- $className componenti -->\n</div>\n");
        CLI::write("Component ve view oluşturuldu: $className");
    }
}
