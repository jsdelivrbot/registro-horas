
<div style=' width:700px; margin:0 auto'>
    <div style='background:#fff; border:#888 solid 1px; border-radius:15px; margin-top:20px; padding:20px; box-shadow:0 0 8px #999'>
        <div style='font-size:16px;font-style: italic;background-color:#fff;border-bottom:1px solid #ccc; padding-bottom:5px;'>
           <h2> Halo </h2>
        </div>
        <div style='font-size:14px; padding-top:20px;'>
            <h3>Welcome To Halo</h3>
            <h3>Hello {{ucwords($user->full_name)}},</h3>
            <p>According to your request we have created a link for reset your password with below credentials .</p>
            <p>
                <a href="{{url('/reset/'.$user->token)}}">CLICK HERE FOR RESET PASSWORD</a>
            </p>
           <!-- <p>
                {{url('/reset/'.$user['token'])}}
            </p>-->
            <p>Thank You <br> Halo Team. </p>
        </div>
    </div>
</div>
