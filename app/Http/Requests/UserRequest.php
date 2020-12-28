<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'name'          => 'required|string|max:255',
                    'email'         => 'required|string|email|max:255|unique:users',
                    'password'      => 'required|string|min:8',
                    'is_enabled'    => 'boolean'
                ];
            case 'PUT':
                return [
                    'name'          => 'required|string|max:255',
                    'email'         => 'required|string|email|max:255',
                    'password'      => 'sometimes|nullable|min:8',
                    'is_enabled'    => 'boolean'
                ];
            case 'PATCH':
                return [
                    'is_enabled'    => 'boolean'
                ];
            default:
                return [];
        }
    }
}
