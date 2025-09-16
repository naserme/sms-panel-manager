@extends("layouts.layout")

@section('content')

    </body>
    <div class="container">
        <h2>ورود با Secret Key</h2>

        @if(isset($error))
            <div class="message">
                <p>{{ $error }}</p>
            </div>
        @endif


        <form action="{{ route('login') }}" method="post">
            @csrf
            <input type="text" name="secret_key" placeholder="Secret Key خود را وارد کنید" required>

            <button type="submit">ورود</button>
        </form>
    </div>

    

@endsection