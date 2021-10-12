<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Barryvdh\Debugbar\Facade as Debugbar;
use Carbon\Carbon;

class PersonalDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Debugbar::info(Auth::user());
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // $current = Carbon::now();
        $date = Carbon::now()->subYears(18)->toDateString();

        return [
            'address_1' => ['regex:/^[a-z\d\-_\s]+$/i', 'required_with:address_2', 'nullable'],
            'address_2' => ['regex:/^[a-z\d\-_\s]+$/i', 'nullable'],
            'pincode' => ['numeric', 'nullable'],
            'pan' => ['regex:/[A-Za-z]{5}[0-9]{4}[A-Za-z]/u', 'nullable'],
            'primary_email' => ['email', 'required_with:secondary_email', 'nullable'],
            'secondary_email' => ['email', 'nullable'],
            'aadhar' => ['regex:/[0-9]{4}-[0-9]{4}-[0-9]{4}/u', 'nullable'],
            'primary_nos' => ['regex:/^[0-9*#+-]+$/u', 'min:8', 'nullable', 'required_with:secondary_nos'],
            'secondary_nos' => ['regex:/^[0-9*#+-]+$/u', 'min:8', 'nullable'],
            'dob' => ['date', 'before:'.$date, 'nullable' ],
        ];
    }
}
