<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompareCityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Bersihkan format angka (hapus titik pemisah ribuan) sebelum validasi
        if ($this->has('umr')) {
            $this->merge(['umr' => str_replace('.', '', $this->umr)]);
        }
        if ($this->has('avg_time')) {
            $this->merge(['avg_time' => str_replace('.', '', $this->avg_time)]);
        }
        if ($this->has('armada_count')) {
            $this->merge(['armada_count' => str_replace('.', '', $this->armada_count)]);
        }
        if ($this->has('private_vehicle')) {
            $this->merge(['private_vehicle' => str_replace('.', '', $this->private_vehicle)]);
        }
        if ($this->has('actual_min_tarif')) {
            $this->merge(['actual_min_tarif' => str_replace('.', '', $this->actual_min_tarif)]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city_name' => 'required|string|max:255',
            'umr' => 'required|numeric|min:0',
            'avg_time' => 'required|numeric|min:0',
            'armada_count' => 'required|integer|min:0',
            'private_vehicle' => 'required|integer|min:0',
            'actual_min_tarif' => 'required|numeric|min:0',
            'kota_pembanding_id' => 'required|exists:kota,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'city_name.required' => 'Nama kota wajib diisi.',
            'city_name.string' => 'Nama kota harus berupa teks.',
            'city_name.max' => 'Nama kota maksimal 255 karakter.',
            'umr.required' => 'UMR wajib diisi.',
            'umr.numeric' => 'UMR harus berupa angka.',
            'umr.min' => 'UMR tidak boleh negatif.',
            'avg_time.required' => 'Waktu tempuh rata-rata wajib diisi.',
            'avg_time.numeric' => 'Waktu tempuh rata-rata harus berupa angka.',
            'avg_time.min' => 'Waktu tempuh rata-rata tidak boleh negatif.',
            'armada_count.required' => 'Jumlah armada wajib diisi.',
            'armada_count.integer' => 'Jumlah armada harus berupa bilangan bulat.',
            'armada_count.min' => 'Jumlah armada tidak boleh negatif.',
            'private_vehicle.required' => 'Jumlah kendaraan pribadi wajib diisi.',
            'private_vehicle.integer' => 'Jumlah kendaraan pribadi harus berupa bilangan bulat.',
            'private_vehicle.min' => 'Jumlah kendaraan pribadi tidak boleh negatif.',
            'actual_min_tarif.required' => 'Tarif minimum aktual wajib diisi.',
            'actual_min_tarif.numeric' => 'Tarif minimum aktual harus berupa angka.',
            'actual_min_tarif.min' => 'Tarif minimum aktual tidak boleh negatif.',
            'kota_pembanding_id.required' => 'Kota pembanding wajib dipilih.',
            'kota_pembanding_id.exists' => 'Kota pembanding yang dipilih tidak valid.',
        ];
    }
}

