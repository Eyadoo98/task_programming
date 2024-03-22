<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteration;
use App\Models\Drawing;
use App\Models\TodoList;
use App\Models\User;
use App\Notifications\NewNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
//use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redis;
//use App\Notifications\NewNotification;
use Illuminate\Support\Facades\Notification as FacadesNotification;
class TodoListController extends Controller
{
    public function getAll():JsonResponse
    {
        $getAllTodoList = TodoList::all();
        Cache::put('todoList', $getAllTodoList);
        return response()->json($getAllTodoList);
    }
    public function getMyTodolist():JsonResponse
    {
        $getMyTodoList = TodoList::where('user_id', auth()->user()->id)->get();
        Cache::put('myTodoList', $getMyTodoList);
        return response()->json($getMyTodoList);
    }

    public function addTolist(Request $request):JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        $todoList = new TodoList();
        $todoList->name = $request->name;
        $todoList->description = $request->description;
        $todoList->user_id = auth()->user()->id;
        $todoList->save();
        return response()->json(['message' => 'Todo list added successfully'], 200);
    }

    public function UpdateTolist(Request $request , $id):JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        $todoList = TodoList::query()->findOrFail($id);
        if (Gate::denies('canUpdate', $todoList)) {
            return response()->json(['message' => 'You are not authorized to update this todo list'], 403);
        }
        $todoList->name = $request->name;
        $todoList->description = $request->description;
        $todoList->save();
        return response()->json(['message' => 'Todo list updated successfully'], 200);
    }
    public function deleteMyTodolist(TodoList $list):JsonResponse
    {

        if (Gate::denies('canDelete', TodoList::query()->findOrFail($list->id))) {
            return response()->json(['message' => 'You are not authorized to delete this todo list'], 403);
        }
        try {
            $list->delete();
            return response()->json(['message' => 'Todo list deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the todo list'], 500);
        }
    }

    public function searchList(Request $request, $search):JsonResponse
    {
        $searchList = TodoList::query()->where('name', 'like', "%$search%")->get();
        return response()->json($searchList);
    }

}
