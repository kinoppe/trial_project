<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => ['required','string','max:20'],
            'postal_code' => ['nullable','string','size:8','regex:/^[0-9]{3}-[0-9]{4}$/'],
            'address' => ['nullable','string'],
            'building' => ['nullable','string'],
            'profile_image' => ['nullable','image','mimes:jpeg,png']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.max' => '名前は20文字以内で入力してください',
            'postal_code.size' => '郵便番号はハイフンありの8文字で入力してください',
            'postal_code.regex' => '郵便番号は123-4567の形式で入力してください',
            'address.required' => '住所を入力してください',
            'profile_image.mimes' => 'プロフィール画像は.jpegまたは.png形式でアップロードしてください'
        ];
    }
}
