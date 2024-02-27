<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    
/**
 * @OA\Get(
 *     path="/api/tasks",
 *     summary="Get all tasks",
 *     description="Returns a list of all tasks.",
 *     operationId="getAllTasks",
 *     tags={"Tasks"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=200
 *             ),
 *             @OA\Property(
 *                 property="tasks",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Task")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No tasks found",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=404
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Not found"
 *             )
 *         )
 *     )
 * )
 */
    public function index(){
        $tasks=Task::all();
        if(count($tasks)>0){
            return response()->json([
                "status"=>200,
                "tasks"=>$tasks,
            ],200);
        }
        else
        return response()->json([
            "status"=>404,
            "message"=>"Not found",
        ],404);
    }

/**
 * @OA\Post(
 *      path="/tasks",
 *      operationId="storeTask",
 *      tags={"Tasks"},
 *      summary="Create a new task",
 *      description="Create a new task",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/TaskRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Task created successfully",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="status",
 *                  type="integer",
 *                  format="int32",
 *                  description="HTTP status code"
 *              ),
 *              @OA\Property(
 *                  property="message",
 *                  type="string",
 *                  description="Success message"
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Something went wrong",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="status",
 *                  type="integer",
 *                  format="int32",
 *                  description="HTTP status code"
 *              ),
 *              @OA\Property(
 *                  property="message",
 *                  type="string",
 *                  description="Error message"
 *              )
 *          )
 *      )
 * )
 */
    public function store(TaskRequest $request){
        $validator=$request->validated();
            if($validator['priorite']=='') $priorite="Medium";
            else $priorite=$validator['priorite'];

            $task=Task::create([
                "title" => $validator['title'],
                "description"=>$validator['description'],
                "priorite"=>$priorite,
                "end_date"=>$validator['end_date'],
                "user_id"=>Auth::id(),
            ]);

            if($task){
                return response()->json([
                    'status'=>200,
                    'message'=>'Task created successfully',
                ],200);
            }
            else{
                return response()->json([
                    'status'=>500,
                    'message'=>'Something went wrong',
                ],500);
            }
        
    }
    
    /**
 * @OA\Get(
 *      path="/tasks/{id}",
 *      operationId="getTaskById",
 *      tags={"Tasks"},
 *      summary="Get task details",
 *      description="Returns task details",
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID of the task",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="status",
 *                  type="integer",
 *                  format="int32",
 *                  description="HTTP status code"
 *              ),
 *              @OA\Property(
 *                  property="Task",
 *                  ref="#/components/schemas/Task"
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Task not exist",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="status",
 *                  type="integer",
 *                  format="int32",
 *                  description="HTTP status code"
 *              ),
 *              @OA\Property(
 *                  property="message",
 *                  type="string",
 *                  description="Error message"
 *              )
 *          )
 *      )
 * )
 */
    public function show($id){
        $task=Task::find($id);
        if($task){
            return response()->json([
                'status'=>200,
                'Task'=>$task,
            ],200);
        }
        else  
            return response()->json([
                'status'=>404,
                'message'=>'Task not exist',
            ],404);
    }

    /**
 * @OA\Delete(
 *      path="/tasks/{id}",
 *      operationId="deleteTask",
 *      tags={"Tasks"},
 *      summary="Delete an existing task",
 *      description="Delete an existing task",
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID of the task",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Task deleted successfully",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="status",
 *                  type="integer",
 *                  format="int32",
 *                  description="HTTP status code"
 *              ),
 *              @OA\Property(
 *                  property="message",
 *                  type="string",
 *                  description="Success message"
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Task not exist",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="status",
 *                  type="integer",
 *                  format="int32",
 *                  description="HTTP status code"
 *              ),
 *              @OA\Property(
 *                  property="message",
 *                  type="string",
 *                  description="Error message"
 *              )
 *          )
 *      )
 * )
 */
    public function destroy($id){
        $task=Task::find($id);
        if($task){
            $task->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Task deleted successfully',
            ],200);
        }
        else  
            return response()->json([
                'status'=>404,
                'message'=>'Task not exist',
            ],404); 
    }

    /**
 * @OA\Put(
 *      path="/tasks/{id}",
 *      operationId="updateTask",
 *      tags={"Tasks"},
 *      summary="Update an existing task",
 *      description="Update an existing task",
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID of the task",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/TaskRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Task updated successfully",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="status",
 *                  type="integer",
 *                  format="int32",
 *                  description="HTTP status code"
 *              ),
 *              @OA\Property(
 *                  property="message",
 *                  type="string",
 *                  description="Success message"
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Something went wrong",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="status",
 *                  type="integer",
 *                  format="int32",
 *                  description="HTTP status code"
 *              ),
 *              @OA\Property(
 *                  property="message",
 *                  type="string",
 *                  description="Error message"
 *              )
 *          )
 *      )
 * )
 */
    public function update(TaskRequest $request,$id){
        $validator=$request->validated();
        $task=Task::find($id);
        if($task){
           
                $task->update($validator);
                if($task){
                    return response()->json([
                        'status'=>200,
                        'message'=>'Task updated successfully',
                    ],200);
                }
                else{
                    return response()->json([
                        'status'=>500,
                        'message'=>'Something went wrong',
                    ],500);
                }
        }
        else  
            return response()->json([
                'status'=>404,
                'message'=>'Task not exist',
            ],404);
    }

    public function affiche($id){
        $task=Task::find($id);
        return new TaskResource($task);
    }
    public function affiche_all(){

        $tasks=Task::all();
        return TaskResource::collection($tasks);
    }


}
