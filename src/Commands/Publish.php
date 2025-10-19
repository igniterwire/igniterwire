<?php
namespace IgniterWire\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Publish extends BaseCommand
{
    protected $group       = 'IgniterWire';
    protected $name        = 'igniterwire:publish';
    protected $description = 'IgniterWire varlıklarını (assets) projenize kopyalar';
    protected $usage       = 'igniterwire:publish';

    public function run(array $params)
    {
        $targetDir = FCPATH . 'vendor/igniterwire/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $source = __DIR__ . '/../Assets/igniterwire.js';
        $target = $targetDir . 'igniterwire.js';
        if (copy($source, $target)) {
            CLI::write('igniterwire.js başarıyla publish edildi: ' . $target, 'green');
        } else {
            CLI::error('igniterwire.js publish edilemedi!');
        }
    }
}
