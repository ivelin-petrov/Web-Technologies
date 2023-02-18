<?php
    
    class Item implements JsonSerializable {
        private $provider;
        private $instance;
        private $vcpu; 
        private $memory;
        private $storage;
        private $network; // Gbps
        private $price;
        private $region;

        public function __construct(string $provider, string $instance, int $vcpu, int $memory, 
                                    string $storage, int $network, float $price, string $region){
            $this->provider = $provider;
            $this->instance = $instance;
            $this->vcpu = $vcpu;
            $this->memory = $memory;
            $this->storage = $storage;
            $this->network = $network;
            $this->price = $price;
            $this->region = $region;
        }

        public function jsonSerialize(): array {
            return [
                'provider' => $this->provider,
                'instance' => $this->instance,
                'vcpu' => $this->vcpu,
                'memory' => $this->memory,
                'storage' => $this->storage,
                'network' => $this->network,
                'price' => $this->price,
                'region' => $this->region,
            ];
        }
    };

?>