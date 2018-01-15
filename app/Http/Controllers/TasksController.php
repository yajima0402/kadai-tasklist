<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Task;    // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::User();
   //     $tasks = Task::all();

        if (\Auth::check()) {
        if (\Auth::user()->id != $task->user_id) {
 
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
        }
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = \Auth::User();
      //  $task = new Task;
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:255',
          ]);
        $request->user()->tasks()->create(
            [
                'status' => $request->status,
                'content' => $request->content,
           ]
        );
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $task = Task::find($id);

        if (\Auth::check()) {
            if (\Auth::user()->id === $task->user_id) {
                // ログインしていて且つ自分のタスクだったら表示
                return view('tasks.show ', [
                    'task' => $task,
                ]);
             } else {
                // 自分のタスクじゃなかったらリダイレクト
                return redirect('/');
            }
        }
        // ログインしていなかったらリダイレクト
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);

        if (\Auth::check()) {
          if (\Auth::user()->id === $task->user_id) {

            return view('tasks.edit', [
                'task' => $task,
            ]);
         }else {
         return redirect('/');
         }
      }
      return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'status' => 'required|max:10',
            'content' => 'required|max:255', 
    ]);

        $task = Task::find($id);

        if (\Auth::check()) { 
          if (\Auth::user()->id === $task->user_id) {

          $task->status = $request->status;
          $task->content = $request->content;
          $task->save();
       
        } else { 
          return redirect('/');
        }
      } 
          return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (\Auth::check()) {
          if (\Auth::user()->id === $task->user_id) {
          $task->delete();
        }  else{
            return redirect('/');
        }
      }
         return redirect('/');
   }
}
