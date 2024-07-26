<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        if(request()->prevoius_address){
            return [
                'first_name' => ['nullable'],
                'last_name' => ['nullable'],
                'email' => ['nullable'],
                'address_1' => ['nullable'],
                'address_2' => ['nullable'],
                'city' => ['nullable'],
                'post_code' => ['nullable'],
                'phone' => ['nullable'],
            ];
            
        }else{
            return [
                'first_name' => ['required', 'max:40'],
                'last_name' => ['required', 'max:40'],
                'email' => ['required', 'max:40', 'email'],
                'address_1' => ['required', 'max:200'],
                'address_2' => ['required', 'max:200'],
                'city' => ['required', 'max:50'],
                'post_code' => ['required', 'max:10'],
                'phone' => ['required', 'max:15'],
            ];
        }

    }
} 
