<?php
declare(strict_types=1);
namespace iggyvolz\Lizzy;
use Discord\Discord;
use Discord\Slash\Parts\Interaction;
use Discord\Slash\Client;
use Discord\Slash\Parts\Choices;
use Discord\Slash\RegisterClient;

class LizzyBot
{
    private Discord $discord;
    private Client $client;
    private RegisterClient $registerClient;
    private MainCommandGroup $mainCommandGroup;

    public function __construct(private string $token, private ?string $guild = null, private bool $debug = false)
    {
        $this->discord = new Discord([
            "token" => $this->token
        ]);
        $this->client = new Client([
            "loop" => $this->discord->getLoop()
        ]);
        $this->client->linkDiscord($this->discord);
        $this->registerClient = new RegisterClient($this->token);
        $this->mainCommandGroup = new MainCommandGroup($this->discord);
    }

    public function run(): void
    {
        $this->mainCommandGroup->register($this->registerClient, $this->client, $this->guild);
        $this->discord->run();
    }
    public function __destruct()
    {
        if($this->debug) {
            foreach($this->registerClient->getCommands($this->guild) as $command) {
                $this->registerClient->deleteCommand($command);
            }
        }
    }
}