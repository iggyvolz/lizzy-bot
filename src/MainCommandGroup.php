<?php

namespace iggyvolz\Lizzy;

use Discord\Discord;

class MainCommandGroup extends LizzyCommandGroup
{
    public function __construct(Discord $discord)
    {
        $this->children = [
            new ShutdownCommand($discord),
            new HelloCommand()
        ];
    }

    protected function getName(): string
    {
        return "lizzy";
    }

    protected function getDescription(): string
    {
        return "A bot for Engineering House";
    }

    /**
     * @inheritDoc
     */
    protected function getChildren(): array
    {
        return $this->children;
    }
}