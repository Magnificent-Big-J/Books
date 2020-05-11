<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePublisherRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:publishers,' . $this->id
        ];
    }
    public function updatePublisher($publisher)
    {
        $publisher->name = $this->get('name');
        $publisher->save();
        session()->flash('success', 'Publisher is successfully updated.');
    }
}
