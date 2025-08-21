<?php
namespace IgniterWire;

abstract class Component
{
    protected $state = [];
        public function __construct()
        {
            $this->syncPropertiesToState();
        }

        /**
         * Tüm public/protected property'leri $state dizisine aktarır
         */
        protected function syncPropertiesToState()
        {
            $reflection = new \ReflectionObject($this);
            foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED) as $prop) {
                $name = $prop->getName();
                if ($name === 'state') continue;
                $this->state[$name] = $this->$name;
            }
        }

    public function __get($name)
    {
        return $this->state[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->updating($name, $value);
        $this->state[$name] = $value;
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
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
        // Hem $state hem de property'leri view'a aktar
        $data = $this->state;
        $reflection = new \ReflectionObject($this);
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED) as $prop) {
            $name = $prop->getName();
            if ($name === 'state') continue;
            $data[$name] = $this->$name;
        }
        return $data;
    }
    {
        $this->updating($name, $value);
        $this->state[$name] = $value;
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
        $updateMethod = 'update' . ucfirst($name);
        if (method_exists($this, $updateMethod)) {
            $this->$updateMethod($value);
        }
        $this->updated($name, $value);
    }
    /**
     * Component oluşturulurken çağrılır
     */
    public function mount(...$params)
    {
        // override edilebilir
    }

    /**
    abstract class Component
    {
        protected $state = [];

        public function __construct()
        {
            $this->syncPropertiesToState();
        }

        /**
         * Tüm public/protected property'leri $state dizisine aktarır
         */
        protected function syncPropertiesToState()
        {
            $reflection = new \ReflectionObject($this);
            foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED) as $prop) {
                $name = $prop->getName();
                if ($name === 'state') continue;
                $this->state[$name] = $this->$name;
            }
        }

        public function __get($name)
        {
            return $this->state[$name] ?? null;
        }

        public function __set($name, $value)
        {
            $this->updating($name, $value);
            $this->state[$name] = $value;
            if (property_exists($this, $name)) {
                $this->$name = $value;
            }
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
            // Hem $state hem de property'leri view'a aktar
            $data = $this->state;
            $reflection = new \ReflectionObject($this);
            foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED) as $prop) {
                $name = $prop->getName();
                if ($name === 'state') continue;
                $data[$name] = $this->$name;
            }
            return $data;
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
