<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class CaptchaServiceController extends Controller
{
    public function capthcaFormValidate(Request $request)
    {
        $request->validate([
            'captcha' => 'required|captcha'
        ], [
            'captcha.captcha' => 'Введите правильный текст с картинки'
        ]);

        return response(['captcha'=>true]);
    }
}
