<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class AddUserRequest extends Request
{

    public function storableAttrs()
    {
        $atrributes = [

            'first_name' => $this->input('first_name'),
            'email' => $this->input('email'),
            'password' => $this->input('password')
        ];
    }
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
        $rules = [
            'first_name'=>'required|max:190',
            'email'=>'required|email|unique:users',
            'password' => 'required|min:4'
        ];
        return $rules;
    }
}
