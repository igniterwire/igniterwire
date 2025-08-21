<?php
namespace IgniterWire\Traits;

trait SweetAlert
{
    protected $sweetAlertData = [];

    public function sweetalert($title, $text = '', $type = 'success')
    {
        $this->sweetAlertData = [
            'title' => $title,
            'text' => $text,
            'type' => $type
        ];
    }

    public function getSweetAlertData()
    {
        return $this->sweetAlertData;
    }
}
