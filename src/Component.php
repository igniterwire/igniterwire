<?php
namespace IgniterWire;

abstract class Component
{
    protected $state = [];

    public function __get($name)
    {
        return $this->state[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->updating($name, $value);
        $this->state[$name] = $value;
        $updateMethod = 'update' . ucfirst($name);
        if (method_exists($this, $updateMethod)) {
            $this->$updateMethod($value);
        }
        $this->updated($name, $value);
    }

    /**
     * View dosyasına değişkenleri aktarır
     */
    public function getViewData()
    {
        return $this->state;
    }

    /**
     * Component oluşturulmadan hemen önce çağrılır
     */
    public function beforeMount()
    {
        // override edilebilir
    }

    /**
     * Component oluşturulurken çağrılır
     */
    public function mount(...$params)
    {
        // override edilebilir
    }

    /**
     * Component oluşturulduktan sonra çağrılır
     */
    public function afterMount()
    {
        // override edilebilir
    }

    /**
     * Component hydrate edilirken (state yüklenirken)
     */
    public function hydrate()
    {
        // override edilebilir
    }

    /**
     * Component dehydrate edilirken (state kaydedilirken)
     */
    public function dehydrate()
    {
        // override edilebilir
    }

    /**
     * Herhangi bir property güncellenmeden önce
     */
    public function updating($property, $value)
    {
        // override edilebilir
    }

    /**
     * Herhangi bir property güncellendikten sonra
     */
    public function updated($property, $value)
    {
        // override edilebilir
    }

    /**
     * Componentin view'ı render edilir
     */
    abstract public function render();
}
