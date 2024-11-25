<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubscriberDataTable;
use App\Http\Controllers\Controller;
use App\Mail\NewsLetter;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mail;

class NewsLetterController extends Controller
{
    function index(SubscriberDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('admin.news-letter.index');
    }

    function sendNewsLetter(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'max:255'],
            'message' => ['required']
        ]);
        $subscribers = Subscriber::pluck('email')->toArray();

        foreach ($subscribers as $subscriberEmail) {
            Mail::to($subscriberEmail)
                ->bcc(array_diff($subscribers, [$subscriberEmail]))
                ->send(new NewsLetter($request->subject, $request->message, $subscriberEmail));
        }/* this part is used to individuly send email */


        // Mail::to($subscribers)->send(new NewsLetter($request->subject, $request->message)); /* to all emails to to section */

        toastr()->success('News letter sent successfully!');

        return redirect()->back();
    }
}
