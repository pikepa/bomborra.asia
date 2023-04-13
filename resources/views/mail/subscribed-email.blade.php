@component('mail::message')
# Bomborra Media Updates

Thank you for submitting your email to receive updates from our site. Please click on the link below to confirm your email address.

If this was not you, then please ignore this email and your address will be deleted from our system after 6 hours.


<div class="mx-auto">
    <a href="{{url('verifyOTP')}}/{{$ID}}/{{$OTP}}" class="block" >
        <button class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Click to Verify
            </button>
    </a>
    <br/>
    <br/>
</div>


Thanks,<br>
{{ config('app.name') }}
<div class="mx-auto">
    <a href="{{ Illuminate\Support\Facades\URL::signedRoute('unsubscribe', ['id' => $ID]) }}"  >
        To completely unsubscribe, click here.
    </a>
    <br/>
    <br/>
</div>
@endcomponent
