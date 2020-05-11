<?php

namespace App\Http\Requests;

use App\Book;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
            'isbn' => 'required|unique:books,' . $this->id,
            'title' => 'required',
            'pub_date' => 'required',
            'pub_id'    => 'required',
            'author_id' => 'required',
            'category_id' => 'required',
            'price' => 'required'
        ];
    }

    /**
     * Create book using the provided request data
     */
    public function createBook()
    {
        Book::create($this->all());
        session()->flash('success', 'Book is successfully created.');
    }

    public function updateBook($book)
    {
        $book->update($this->all());
        session()->flash('success', 'Book is successfully updated.');
    }
}
