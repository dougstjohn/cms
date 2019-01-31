<?php

namespace Statamic\Actions;

use Statamic\API;

class Delete extends Action
{
    protected $dangerous = true;

    public function visibleTo($key, $context)
    {
        return true;
    }

    public function run($items)
    {
        $items->each(function ($entry) {
            $entry->set('title', $entry->get('title') . ' (Deleted)')->save();
        });
    }
}