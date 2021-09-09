<?php

namespace iggyvolz\Lizzy;

use Discord\Slash\Client;
use Discord\Slash\Enums\ApplicationCommandOptionType;
use Discord\Slash\Parts\Choices;
use Discord\Slash\Parts\Command;
use Discord\Slash\Parts\Interaction;
use Discord\Slash\RegisterClient;

abstract class LizzyCommandGroup extends LizzyCommand
{
    protected function registerHandler(Client $client, string|array|null $name = null): void
    {
        if(!is_array($name)) {
            $name = [$name ?? $this->getName()];
        }
        foreach($this->getChildren() as $child) {
            $child->registerHandler($client, [...$name, $child->getName()]);
        }
    }

    protected function getOptions(): array
    {
        return array_map(fn(LizzyCommand $command) => [
            "name" => $command->getName(),
            "description" => $command->getDescription(),
            "type" => $command instanceof LizzyCommandGroup ? ApplicationCommandOptionType::SUB_COMMAND_GROUP : ApplicationCommandOptionType::SUB_COMMAND
        ], $this->getChildren());
    }

    /**
     * @return LizzyCommand[]
     */
    protected abstract function getChildren(): array;
    public final function run(Interaction $interaction, Choices $choices): void
    {
        throw new \LogicException("Cannot run a command group");
    }
}