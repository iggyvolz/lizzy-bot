<?php

namespace iggyvolz\Lizzy;

use Discord\Slash\Parts\Choices;
use Discord\Slash\Parts\Interaction;

class HelloCommand extends LizzyCommand
{
    protected function getName(): string
    {
        return "hello";
    }

    protected function getDescription(): string
    {
        return "Says hello back!";
    }

    public function run(Interaction $interaction, Choices $choices): void
    {
        var_dump($interaction->guild);
        $interaction->reply("Hello!");
    }
}