<?php

    namespace App\Http\Requests;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;

    class AddReviewRequest extends Request
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            return !is_null(Auth::user());
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            $data = json_decode($this->request->get('data'), true);
            Log::info($data['cost']);
            if (!$this->isValid($data['cost'] || !$this->isValid($data['quality']) || !$this->isValid($data['decor'])))

            $rules = [];
            return $rules;

            /*  foreach ($data as $key => $val)
              {
                  if ($key == "review-text")
                  {
                      $rules['review-text'] = 'required|min:70';
                  }
              }*/

            /*if (in_array($key, $numberic))
       {
           $rules[$key.'rating'] = 'required|integer|min:1|max:5';
           Log::info($key." in array and value: ".$val);
       }*/
            /* $this->validate($data, [
                 'quality'     => 'required|Min:1|Max:5',
                 'decor'       => 'required|Min:1|Max:5',
                 'cost'        => 'required|Min:1|Max:5',
                 'review-text' => 'required|Min:70'
             ]);
             return [
             ];*/
        }

        private function isValid($value)
        {
            return ($value >= 1) && ($value <= 5);
        }
    }
