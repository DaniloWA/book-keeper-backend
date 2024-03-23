<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait DefaultMessages
{

    public function defaultMessage(): array
    {
        return [
            'required' => 'We need your [ ' . Str::upper(':attribute') . ' ] to continue!',
            'email' => 'This email looks fake to me',
            'unique' => 'Someone already picked this [ ' . Str::upper(':attribute') . ' ] try another one!',
            'min' => 'Your [ ' . Str::upper(':attribute') . ' ] must be longer than :min characters',
            'max' => 'Your [ ' . Str::upper(':attribute') . ' ] must be a maximum of :max characters',
            'status' => 'Your [ ' . Str::upper(':attribute') . ' ] must be one of : read, reading, abandoned, want_to_read',
        ];
    }
}
