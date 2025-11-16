<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\LoginPhoneRequest;
use App\Repositories\UsersRepository;
use App\Services\NotificationContextService;
use App\Strategies\SmsDotIrStrategy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function loginByPhoneNumber (LoginPhoneRequest $request)
    {
        $phone = $request['phone'];
        $user = $this->usersRepository->setModel()::where('phone', $phone)->get()->first();

        if (null === $user) {
            return redirect()->back()->with('error', 'کاربری یافت نشد');
        }

//        $notifiationContex1 = new NotificationContextService(
//            new SmsDotIrStrategy()
//        );

        $code = mt_rand(1, 1000000);

//        $notifiationContex1->sendNotification(null, [$request['phone']], $code);

        $this->usersRepository->setModel()::where('phone', $phone)->update(['otp_code' => $code]);

        return redirect()->route('auth.phone.verify')->with('phone', $phone);
    }

    public function checkAndLogin(Request $request)
    {
        $verficationCode = $request['verficationCode'];
        $phone = $request['phone'];

        if (null == $verficationCode || null == $phone) {
            return redirect()->back()->with('error', 'کاربری یافت نشد');
        }

        $user = $this->usersRepository->setModel()::where('phone', $phone)->get()->first();

        if ($verficationCode === $user['otp_code']) {
            Auth::login($user);

            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'کد تایید اشتباه است');
    }
}
