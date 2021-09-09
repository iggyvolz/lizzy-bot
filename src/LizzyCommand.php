<?php

namespace iggyvolz\Lizzy;

use Discord\Slash\Client;
use Discord\Slash\Parts\Choices;
use Discord\Slash\Parts\Interaction;
use Discord\Slash\RegisterClient;

abstract class LizzyCommand
{
    protected function registerCommand(RegisterClient $registerClient, ?string $guild): void
    {
        if(is_null($guild)) {
            $registerClient->createGlobalCommand($this->getName(), $this->getDescription(), $this->getOptions());
        } else {
            $registerClient->createGuildSpecificCommand($guild, $this->getName(), $this->getDescription(), $this->getOptions());
        }
    }
    protected function registerHandler(Client $client, string|array|null $name = null): void
    {
        $client->registerCommand($name ?? $this->getName(), function(Interaction $interaction, Choices $choices) { $this->run($interaction, $choices); });
    }
    public function register(RegisterClient $registerClient, Client $client, ?string $guild): void
    {
        $this->registerCommand($registerClient, $guild);
        $this->registerHandler($client);
    }


    protected abstract function getName(): string;
    protected abstract function getDescription(): string;
    protected function getOptions(): array
    {
        return [];
    }

    public abstract function run(Interaction $interaction, Choices $choices): void;
}