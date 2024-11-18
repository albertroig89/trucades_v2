<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Job;
use Carbon\Carbon;

class ExportJobFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'initdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:initdate',
            'client_id' => 'nullable|exists:clients,id',
            'user_id' => 'nullable|exists:users,id',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'inittime.required' => 'La fecha de inicio es obligatoria',
            'endtime.required' => 'La fecha final es obligatoria',
            'endtime.after_or_equal' => 'La fecha final debe ser posterior o igual a la fecha de inicio',
        ];
    }

    /**
     * Build the query based on the validated request data.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buildQuery()
    {
        $inittime = Carbon::parse($this->input('initdate'));
        $endtime = Carbon::parse($this->input('enddate'))->endOfDay();

        // Crear una consulta inicial para los trabajos
        $query = Job::whereBetween('inittime', [$inittime, $endtime]);

        // Aplicar filtros si se especifica un cliente
        if ($this->filled('client_id')) {
            $query->where('client_id', $this->input('client_id'));
        }

        // Aplicar filtros si se especifica un empleado
        if ($this->filled('user_id')) {
            $query->where('user_id', $this->input('user_id'));
        }

        // Ordenar los trabajos por cliente y luego por usuario
        $query->orderBy('client_id')->orderBy('user_id')->orderBy('inittime');

        return $query;
    }

}
