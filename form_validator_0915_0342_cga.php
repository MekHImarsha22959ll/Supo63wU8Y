<?php
// 代码生成时间: 2025-09-15 03:42:43
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator as ValidationFacade;

class FormValidator {
    /**
     * Validate the given request data.
     *
     * @param Request $request
     * @return void
     *
     * @throws ValidationException
     */
    public function validate(Request $request) {
        $validator = $this->makeValidator($request);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Create a validator instance for the request data.
     *
     * @param Request $request
     * @return Validator
     */
    protected function makeValidator(Request $request): Validator {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            // Add more rules as needed
        ];

        return ValidationFacade::make($request->all(), $rules);
    }
}
