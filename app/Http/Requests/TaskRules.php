<?php

namespace App\Http\Requests;

use App\Models\Task;

trait TaskRules
{
    /**
     * @return array<string, mixed>
     */
    private function taskRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:' . Task::STATUS_PENDING . ',' . Task::STATUS_DONE],
            'deadline' => ['nullable', 'date'],
        ];
    }
}
