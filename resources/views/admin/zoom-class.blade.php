<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SOMA | Classroom | {{$classroom->title}}</title>
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.6/css/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.6/css/react-select.css"/>
    <style type="text/css">
        #zmmtg-root {
            background-color: transparent !important;
            position: relative !important;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <noscript>
        <strong>We're sorry but poc doesn't work properly without JavaScript enabled. Please enable it to
            continue.</strong>
    </noscript>
    <div id="zmmtg-root"></div>
</div>
<script src="https://source.zoom.us/1.9.6/lib/vendor/react.min.js"></script>
<script src="https://source.zoom.us/1.9.6/lib/vendor/react-dom.min.js"></script>
<script src="https://source.zoom.us/1.9.6/lib/vendor/redux.min.js"></script>
<script src="https://source.zoom.us/1.9.6/lib/vendor/redux-thunk.min.js"></script>
<script src="https://source.zoom.us/1.7.9/lib/vendor/jquery.min.js"></script>
<script src="https://source.zoom.us/1.9.6/lib/vendor/lodash.min.js"></script>
<script src="https://source.zoom.us/zoom-meeting-1.9.6.min.js"></script>
<script type="text/javascript">
    ZoomMtg.preLoadWasm();
    ZoomMtg.prepareJssdk();
    let settings = {!! json_encode($user->settings) !!};
    let userSettings = JSON.parse(JSON.stringify(settings));
    //console.log(userSettings);
    $(document).ready(function () {
        // Meeting config object
        let meetingConfig = {
            apiKey: '{{env("ZOOM_API_KEY")}}',
            apiSecret: '{{env("ZOOM_API_SECRET")}}',
            meetingNumber: '{{$classroom->meetingId}}',
            userName: '{{$user->fullName}}',
            passWord: '{{$classroom->meetingPassword}}',
            leaveUrl: "about:blank",
            role: {{($user->isStudent) ? 0 : 1}}
        };
        let config = {
            leaveUrl: meetingConfig.leaveUrl,
            videoHeader: true,
            ...userSettings,
            meetingInfo: [
                'topic',
                'host',
            ],
        };
        console.log(config);
        // Generate Signature function
        let signature = ZoomMtg.generateSignature({
            meetingNumber: meetingConfig.meetingNumber,
            apiKey: meetingConfig.apiKey,
            apiSecret: meetingConfig.apiSecret,
            role: meetingConfig.role,
            success: (res) => {
                // eslint-disable-next-line
                console.log("success signature: " + res.result);
            }
        });
        // join function
        ZoomMtg.init({
            ...config,
            success: () => {
                ZoomMtg.join({
                    meetingNumber: meetingConfig.meetingNumber,
                    userName: meetingConfig.userName,
                    signature: signature,
                    apiKey: meetingConfig.apiKey,
                    userEmail: "{{$user->email}}",
                    passWord: meetingConfig.passWord,
                    success: (res) => {
                        // eslint-disable-next-line
                        console.log("join meeting success");
                    },
                    error: (error) => {
                        // eslint-disable-next-line
                        console.log(error);
                    }
                });
            },
            error: (res) => {
                // eslint-disable-next-line
                console.log(res);
            }
        });
    });
</script>
</body>
</html>
