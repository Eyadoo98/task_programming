@extends('layouts.app')

@section('content')

{{--    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>--}}
{{--    <script>--}}

{{--        @php--}}
{{--            $userId = auth()->check() ? auth()->user()->id:0;--}}
{{--        @endphp--}}

{{--        // Enable pusher logging - don't include this in production--}}
{{--        Pusher.logToConsole = true;--}}

{{--        var pusher = new Pusher('PUSHER_APP_KEY', {--}}
{{--            cluster: 'yourcluster'--}}
{{--        });--}}

{{--        var channel = pusher.subscribe('my-channel');--}}
{{--        channel.bind("Illuminate\\Notifications\\Events\\BroadcastNotificationCreated", function(data) {--}}

{{--            if(data.user_id == {{$userId}}){--}}

{{--                alert(`Hi ${data.comment}`) //here you can add you own logic--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
<div class="container">
    @livewire('todo-list')

</div>
@endsection
