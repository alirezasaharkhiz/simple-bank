<?php

namespace App\Http\Requests;

use App\Constants\Constants;
use App\Rules\CardNumber;
use Illuminate\Foundation\Http\FormRequest;

class MakeTransactionRequest extends FormRequest
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
            'from' => ['required', new CardNumber()],
            'to' => ['required', new CardNumber()],
            'amount' => ['required', 'numeric', 'min:'.Constants::MIN_AMOUNT_OF_TRANSACTION, 'max:'.Constants::MAX_AMOUNT_OF_TRANSACTION]
        ];
    }
}
