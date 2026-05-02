<?php

namespace App\Http\Requests;

use App\Models\Task;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    use TaskRules;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return array_merge($this->baseTaskRules(), [
            'deadline' => ['nullable', 'date', $this->deadlineMustBeFutureUnlessUnchanged()],
        ]);
    }

    private function deadlineMustBeFutureUnlessUnchanged(): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail): void {
            if ($value === null || $value === '') {
                return;
            }

            /** @var Task $task */
            $task = $this->route('task');
            if ($task->deadline && $task->deadline->format('Y-m-d') === $value) {
                return;
            }

            if ($value < now()->toDateString()) {
                $fail(__('The deadline must be today or a future date.'));
            }
        };
    }
}
