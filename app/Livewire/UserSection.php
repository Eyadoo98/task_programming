<?php

namespace App\Livewire;

use App\Events\UserRegisteration;
use App\Models\User;
use Livewire\Component;

class UserSection extends Component
{
    public $allUsers;

    public $userId;

    public $userIdUpdate;

    public $isModalOpenUpdate;

    public string $taskName;

    public string $taskDescription;

    public  $isModalOpen = false;

    public function render()
    {
        return view('livewire.user-section');
    }

    public function createTask()
    {
        $this->validate([
            'taskName' => 'required',
            'taskDescription' => 'required',
        ]);

        session()->flash('message', 'Task Created Successfully.');

        $users = User::all();
        foreach ($users as $user) {
            $user->TodoList()->create([
                'name' => $this->taskName,
                'description' => $this->taskDescription,
            ]);
        }
        event(new UserRegisteration('New todo list added', 0));

        return redirect()->route('admin');
    }

    public function updateUserId($value)
    {
        $this->userId = $value;
        $this->isModalOpen = true; // Open the modal
        $this->isModalOpenUpdate = true; // Open the modal
    }
    public function updateCustomUserId($id)
    {
        $this->userId = $id;
        $this->isModalOpenUpdate = true; // Open the modal
        $this->userIdUpdate = \App\Models\TodoList::query()->where('user_id', $id)->first();
    }

    public function createCustomTask()
    {
        $this->validate([
            'taskName' => 'required',
            'taskDescription' => 'required',
        ]);

        session()->flash('message', 'Task Created Successfully.');

        $user = User::query()->find($this->userId);
        $user->TodoList()->create([
            'name' => $this->taskName,
            'description' => $this->taskDescription,
        ]);
        event(new UserRegisteration('New todo list added', $user->id));


        return redirect()->route('admin');
    }

    public function updateCustomTask($id)
    {
        $this->validate([
            'taskName' => 'required',
            'taskDescription' => 'required',
        ]);

        session()->flash('message', 'Task Updated Successfully.');
        $list = \App\Models\TodoList::query()->where('id', $id)->first();
        $user = User::query()->find($list->user_id);
        $user->TodoList()->update([
            'name' => $this->taskName,
            'description' => $this->taskDescription,
        ]);
        event(new UserRegisteration('New todo list added', $user->id));
    }
}
