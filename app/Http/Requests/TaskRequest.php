<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="TaskRequest",
 *     title="TaskRequest",
 *     required={"title", "priorite", "end_date"},
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the task",
 *         minLength=2,
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the task"
 *     ),
 *     @OA\Property(
 *         property="priorite",
 *         type="string",
 *         description="The priority of the task",
 *         enum={"low", "medium", "high"}
 *     ),
 *     @OA\Property(
 *         property="end_date",
 *         type="string",
 *         format="date",
 *         description="The end date of the task"
 *     )
 * )
 */
class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:2|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|string|in:low,medium,high',
            // 'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date',
        ];
    }
}
