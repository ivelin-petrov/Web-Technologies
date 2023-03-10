<?php
    
    class Owner implements JsonSerializable {
        private $id;
        private $username;
        private $password;
        private $registeredOn;
        private $lastLoginOn;
        private $introText;

        public function __construct(int $id, string $username, string $password, string $introText) {
            $this->id = $id;
            $this->username = $username;
            $this->password = $password;
            $this->introText = $introText;
        }

        public function getIntroText() : string {
            return $this->introText;
        }

        public function jsonSerialize(): array {
            return [
                'id' => $this->id,
                'username' => $this->username,
                'registeredOn' => $this->registeredOn,
                'lastLogin' => $this->lastLoginOn,
                'introText' => $this->introText,
            ];
        }
    };

?>