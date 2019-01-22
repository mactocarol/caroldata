<?php

declare(strict_types=1);

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    /**
     * The product validation rules.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {

                case 'GET':
                case 'DELETE': {
                        return [];
                    }
                case 'POST': {
                        return [
                            'blog_title'             => 'required',
                            'blog_description'       => 'required',
                            'blog_image'             => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
                        ];
                    }
                case 'PUT':
                case 'PATCH': {

                        return [
                            'blog_title'             => 'required',
                            'blog_description'       => 'required',
                            'blog_image'             => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
                        ];

                }
                default:break;
            }
        //}
    }

    /**
     * The
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
