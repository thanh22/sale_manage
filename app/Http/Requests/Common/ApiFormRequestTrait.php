<?php

namespace App\Http\Requests\Common;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * FormRequestのバリデート結果をJSONに変換して返却するトレイト
 */
trait ApiFormRequestTrait
{
    protected function failedValidation( Validator $validator )
    {
        $response['error']  = $validator->errors()->all();

        throw new HttpResponseException(
            response()->json( $response, CODE_UNPROCESSABLE_ENTITY )
        );
    }
}