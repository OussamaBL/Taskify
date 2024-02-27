<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Task",
 *     title="Task",
 *     description="Task model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier for the task"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the task"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the task"
 *     ),
 *     @OA\Property(
 *         property="priorite",
 *         type="string",
 *         description="The priority of the task"
 *     ),
 *     @OA\Property(
 *         property="start_date",
 *         type="string",
 *         format="date",
 *         description="The start date of the task"
 *     ),
 *     @OA\Property(
 *         property="end_date",
 *         type="string",
 *         format="date",
 *         description="The end date of the task"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="The ID of the user who owns the task"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date/time when the task was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date/time when the task was last updated"
 *     )
 * )
 */

class Task extends Model
{
    use HasFactory;
    protected $table='tasks';
    protected $fillable = [
        'title',
        'description',
        'priorite',
        'start_date',
        'end_date',
        'user_id',

    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
