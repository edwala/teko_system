<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Collection as DBCollection;
use Illuminate\Support\Collection;
use InvadersXX\FilamentKanbanBoard\Pages\FilamentKanbanBoard;


class KanbanTasks extends FilamentKanbanBoard
{
    protected static string $resource = TaskResource::class;

    protected static string $view = 'filament.resources.task-resource.pages.kanban-tasks';

    protected function statuses(): Collection
    {
        return collect([
            [
                'id' => 'registered',
                'title' => 'Registered',
            ],
            [
                'id' => 'awaiting_confirmation',
                'title' => 'Awaiting Confirmation',
            ],
            [
                'id' => 'confirmed',
                'title' => 'Confirmed',
            ],
            [
                'id' => 'delivered',
                'title' => 'Delivered',
            ],
        ]);
    }

    protected function records() : DBCollection
    {
        return Task::all()
            ->map(function (Task $item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'status' => $item->status,
                ];
            });
    }

    public static function route(string $path): array
    {
        return [
            'class' => static::class,
            'route' => $path,
        ];
    }
}
