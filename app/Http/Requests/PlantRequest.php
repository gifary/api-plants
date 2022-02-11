<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\SanitizesInput;
use App\Models\Plant;
use App\Services\Sanitizers\EncodeHtml;
use Illuminate\Foundation\Http\FormRequest;

class PlantRequest extends FormRequest
{
    use SanitizesInput;

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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','string','max:255'],
            'species' => ['required','string','max:255'],
            'watering_instructions' => ['nullable'],
            'image' => ['nullable','image','max:10000']
        ];
    }

    protected function fieldsToSanitize()
    {
        return [
            'watering_instructions' => [EncodeHtml::class]
        ];
    }

    public function persist(Plant $plant = null)
    {
        $plan = $plan ?? new Plant;

        $plan->name = $this->name;
        $plan->species = $this->species;
        $plan->watering_instructions = $this->watering_instructions;

        if ($this->hasFile('image')) {
            $plan->image = $this->file('image')->storePublicly('plant');
        }

        $plan->save();

        return $plan->fresh();
    }
}
