<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\NoDisponibilidad;
use Carbon\Carbon;

class StorePedidoRequest extends FormRequest
{
    /**
     * Autoriza solo a usuarios autenticados (cliente).
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Normaliza algunos campos antes de validar.
     */
    protected function prepareForValidation(): void
    {
        // Asegura estructura de items como array
        $items = $this->input('items', []);
        if (!is_array($items)) {
            $items = [];
        }

        // Normaliza cantidades a enteros >= 0
        foreach ($items as $k => $it) {
            if (is_array($it)) {
                $items[$k]['cantidad'] = isset($it['cantidad'])
                    ? (int) $it['cantidad']
                    : 0;
            }
        }

        // Normaliza fecha_entrega (si viene en otros formatos)
        $fecha = $this->input('fecha_entrega');
        if ($fecha) {
            try {
                $fecha = Carbon::parse($fecha)->format('Y-m-d');
            } catch (\Throwable $e) {
                // deja tal cual, lo atrapará la rule de 'date'
            }
        }

        // Normaliza hora_entrega (si solo se envía la hora)
        $hora = $this->input('hora_entrega');
        if ($hora && preg_match('/^\d{1,2}$/', $hora)) {
            $hora = str_pad($hora, 2, '0', STR_PAD_LEFT) . ':00';
        }

        $this->merge([
            'items' => $items,
            'fecha_entrega' => $fecha,
            'hora_entrega' => $hora,
            'tipo_retiro' => $this->input('tipo_retiro') ?: null,
        ]);
    }

    /**
     * Reglas de validación.
     */
    public function rules(): array
    {
        // Fechas bloqueadas por UC-15 (NoDisponibilidad)
        $fechasBloqueadas = NoDisponibilidad::pluck('fecha')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->toArray();

        return [
            // Ítems del pedido
            'items' => ['required', 'array', 'min:1'],
            'items.*.producto_id' => ['required', 'integer', 'exists:productos,id'],
            'items.*.cantidad' => ['required', 'integer', 'min:0'],

            // Campos del UID (opcionales con líneas punteadas)
            'fecha_entrega' => [
                'required', // <-- Cambia de 'nullable' a 'required'
                'date',
                'after_or_equal:today',
                Rule::notIn($fechasBloqueadas),
            ],
            'hora_entrega' => ['required', 'date_format:H:i'],
            'tipo_retiro' => ['nullable', Rule::in(['retiro', 'envio'])],
            'personalizacion' => ['nullable', 'string', 'max:1000'],
            'forma_pago' => ['nullable', 'string', 'max:30'],
        ];
    }

    /**
     * Mensajes de error personalizados.
     */
    public function messages(): array
    {
        return [
            'items.required' => 'Debés seleccionar al menos un producto.',
            'items.array' => 'El formato de los ítems es inválido.',
            'items.min' => 'El pedido debe contener al menos un ítem.',
            'items.*.producto_id.required' => 'Falta el producto en uno de los ítems.',
            'items.*.producto_id.exists' => 'Algún producto seleccionado no existe.',
            'items.*.cantidad.required' => 'Indicá la cantidad del producto.',
            'items.*.cantidad.integer' => 'La cantidad debe ser un número entero.',
            'items.*.cantidad.min' => 'La cantidad mínima es 0.',
            'items' => 'Debés seleccionar al menos un producto con cantidad mayor a 0.',

            'fecha_entrega.date' => 'La fecha de entrega no es válida.',
            'fecha_entrega.after_or_equal' => 'La fecha de entrega no puede ser anterior a hoy.',
            'fecha_entrega.not_in' => 'La fecha seleccionada no está disponible.',
            'fecha_entrega.required' => 'La fecha de entrega es obligatoria.',
            'hora_entrega.max' => 'La hora de entrega no debe superar 40 caracteres.',
            'hora_entrega.date_format' => 'La hora de entrega debe tener el formato HH:MM.',
            'hora_entrega.required' => 'Debe seleccionar una hora de entrega.',

            'tipo_retiro.in' => 'El tipo de retiro debe ser “retiro” o “envio”.',
            'personalizacion.max' => 'La personalización no debe superar 1000 caracteres.',
            'forma_pago.max' => 'La forma de pago no debe superar 30 caracteres.',
        ];
    }

    /**
     * Etiquetas legibles de los campos.
     */
    public function attributes(): array
    {
        return [
            'items' => 'ítems',
            'items.*.producto_id' => 'producto',
            'items.*.cantidad' => 'cantidad',
            'fecha_entrega' => 'fecha de entrega',
            'horario_preferido' => 'horario preferido',
            'tipo_retiro' => 'tipo de retiro',
            'personalizacion' => 'personalización',
            'forma_pago' => 'forma de pago',
        ];
    }

    /**
     * Validación adicional después de las reglas básicas.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $items = $this->input('items', []);
            $seleccionados = collect($items)->filter(function ($it) {
                return isset($it['cantidad']) && (int)$it['cantidad'] > 0;
            });
            if ($seleccionados->count() < 1) {
                $validator->errors()->add('items', 'Debés seleccionar al menos un producto con cantidad mayor a 0.');
            }
        });
    }
}
