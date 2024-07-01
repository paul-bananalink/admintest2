<?php

namespace App\Broadcasting\Client;

use App\Broadcasting\BaseChannel;

class MemberAccessChannel extends BaseChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(): array|bool
    {
        return true;
    }
}
