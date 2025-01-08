<?php

namespace App\Http\Requests;

use App\Models\HistJob;
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

        // Determinar si la consulta es para trabajos realizados o del histórico
        $isFromHistory = $this->has('export_from_history');
        $model = $isFromHistory ? HistJob::class : Job::class;

        // Crear una consulta inicial basada en el modelo
        $query = $model::whereBetween('inittime', [$inittime, $endtime]);

        // Aplicar filtros si se especifica un cliente
        if ($this->filled('client_id') && !$isFromHistory) {
            $query->where('client_id', $this->input('client_id'));
        }

        // Aplicar filtros si se especifica un empleado (válido en ambos modelos)
        if ($this->filled('user_id')) {
            $query->where('user_id', $this->input('user_id'));
        }

        // Ordenar según las columnas disponibles en el modelo
        if (!$isFromHistory) {
            // Ordenar trabajos normales por cliente, usuario y fecha
            $query->orderBy('client_id')->orderBy('user_id')->orderBy('inittime');
        } else {
            // Ordenar trabajos históricos por usuario y fecha
            $query->orderBy('clientname')->orderBy('username')->orderBy('inittime');
        }

        return $query;
    }

}
