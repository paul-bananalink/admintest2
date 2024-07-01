<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('member-access-page', \App\Broadcasting\Client\MemberAccessChannel::class);
Broadcast::channel('note-page', \App\Broadcasting\Client\NoteChannel::class);
