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

class FacebookPoster extends SocialNetworkPoster{
    private $username, $password;

    public function __construct(string $username, string $password){
        $this->username = $username;
        $this->password = $password;
    }

    public function getSocialNetwork(): SocialNetworkConnector{
        return new FacebookConnector($this->username, $this->password);
    }
}

class TwitterPoster extends SocialNetworkPoster{
    private $email, $password;

    public function __construct(string $email, string $password){
        $this->email = $email;
        $this->password = $password;
    }

    public function getSocialNetwork(): SocialNetworkConnector{
        return new TwitterConnector($this->email, $this->password);
    }
}

interface SocialNetworkConnector{
    public function login(): void;
    public function createPost(string $content): void;
    public function logout(): void;
}

class FacebookConnector implements SocialNetworkConnector{
    private $username, $password;

    public function __construct(string $username, string $password){
        $this->username = $username;
        $this->password = $password;
    }

    public function login(): void{
        echo "Call login Api to connect to facebook with username $this->username<br/>";
    }
    
    public function createPost(string $content): void{
        echo "Call createPost Api to create a post on facebook<br/>";
    }

    public function logout(): void{
        echo "Call logout Api to disconnect from facebook with username $this->username<br/>";
    }
}

class TwitterConnector implements SocialNetworkConnector{
    private $email, $password;

    public function __construct(string $email, string $password){
        $this->email = $email;
        $this->password = $password;
    }

    public function login(): void{
        echo "Call login Api to connect to twitter with email $this->email</br>";
    }

    public function createPost(string $content): void{
        echo "Call createPost Api to create a post on twitter</br>";
    }

    public function logout(): void{
        echo "Call logout Api to disconnect from twitter with email $this->email</br>";
    }
}


function clientCode(SocialNetworkPoster $create){
    $create->post("Hello World!");
}

$client1 = clientCode(new FacebookPoster("h.abedi", "12345"));
$client2 = clientCode(new TwitterPoster("hosein.abedi2000@gmail.com", "12345"));

?>