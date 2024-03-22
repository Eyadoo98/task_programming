<?php

namespace App\Livewire;
use Livewire\Component;

class TodoList extends Component
{
    public string $taskName = '';

    public string $taskDescription = '';

    public array $tasks = [];

    public $userId;

    public $userIdUpdate;

    public $taskNameUpdate , $taskDescUpdate;


    public $isModalOpen = false;
    public $isModalOpenUpdate = false;

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $this->tasks = \App\Models\TodoList::query()->where('user_id', auth()->id())->get()->toArray();
    }
    public function render()
    {
        return view('livewire.todo-list');
    }

    public function createListTodo()
    {
        $task = \App\Models\TodoList::query()->create([
            'name' => $this->taskName,
            'description' => $this->taskDescription,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('home');
    }

    public function deleteUSerTask($id)
    {
        $this->userId = $id;
        $this->isModalOpen = true; // Open the modal
    }
    public function updateUserTask($id)
    {
        $this->userId = $id;
        $this->isModalOpenUpdate = true; // Open the modal
        $this->userIdUpdate = \App\Models\TodoList::query()->where('id', $id)->first();
    }

    public function updateUserTaskId()
    {
        $task = \App\Models\TodoList::query()->where('id', $this->userId)->update([
            'name' => $this->taskNameUpdate,
            'description' => $this->taskDescUpdate,
        ]);
        $this->isModalOpenUpdate = false;
        return redirect()->route('home');
    }
    public function deleteCustomTask()
    {
        $task = \App\Models\TodoList::query()->where('id', $this->userId)->delete();
        $this->isModalOpen = false;
        $this->mount();
    }
}
