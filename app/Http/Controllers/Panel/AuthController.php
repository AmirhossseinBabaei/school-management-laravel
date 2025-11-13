<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\LoginPhoneRequest;
use App\Repositories\UsersRepository;
use App\Services\NotificationContextService;
use App\Strategies\SmsDotIrStrategy;
use Illuminate\Http\Request;

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

//        if (null == $user) {
//            return redirect()->back()->with('error', 'کاربری یافت نشد');
//        }

        $notifiationContex1 = new NotificationContextService(
            new SmsDotIrStrategy($phone)
        );

        $notificationResult = $notifiationContex1->sendNotification('helllo', ['09399008730']);

        $code = mt_rand(1, 1000000);


    }
}
