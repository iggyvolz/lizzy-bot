<?php

namespace iggyvolz\Lizzy;

use Discord\Discord;
use Discord\Slash\Parts\Choices;
use Discord\Slash\Parts\Interaction;

class ShutdownCommand extends LizzyCommand
{
    public function __construct(private Discord $discord)
    {
    }
    protected function getName(): string
    {
        return "shutdown";
    }

    protected function getDescription(): string
    {
        return "Shuts down Lizzy Bot";
    }

    public function run(Interaction $interaction, Choices $choices): void
    {
        // TODO limit this to admins
        $interaction->reply("Goodbye!");
        $this->discord->getLoop()->addTimer(1, fn() => $this->discord->close());
    }
}