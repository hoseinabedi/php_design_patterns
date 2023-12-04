<?php
abstract class SocialNetworkPoster{
    abstract public function getSocialNetwork(): SocialNetworkConnector;

    public function post($content): void{
        $network = $this->getSocialNetwork();
        $network->login();
        $network->createPost($content);
        $network->logout();
    }
}

interface SocialNetworkConnector{
    public function login(): void;
    public function createPost(): void;
    public function logout(): void;
}

?>