@extends('layouts.layout')

@section('content')

<div style="display: flex; justify-content: center; flex-wrap: wrap; max-width: 1200px; margin: 20px auto; gap: 20px; padding: 10px; box-sizing: border-box;">
    <!-- کارت خوشامدگویی -->
    <div style="flex: 0 1 300px; background:#fff; border-radius:10px; padding:15px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
    <center>

            <h4>سلام، {{ $admin->fname }} 👋</h4>
            <br>
                <form style=" width: 75px;" action="{{ route('logout') }}" method="post" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            
            @if(route('admin'))
            @else
            <!-- فیلتر پیام ها -->
            <div style="background: #fff; border-radius: 10px; padding: 20px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 15px;">فیلتر پیام ها</h3>
                <form action="{{ route('dashboard') }}" method="get">
                    @csrf
                    <p>از تاریخ</p>
                    <input type="datext" data-jdp name="startDate" placeholder="از تاریخ" data-jdp-only-date required>
                    <p>تا تاریخ</p>
                    <input type="datext" data-jdp name="endDate" placeholder="تا تاریخ" data-jdp-only-date required>
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <button type="submit">ارسال</button>
                </form>
            </div>
            @endif
        </center>
        </div><br>
</div>


<!-- بخش پیام‌ها -->
<div style="flex: 3 1 500px; background:#fff; border-radius: 10px; padding: 20px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom: 15px;">پیام‌های ارسال شده</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">

        @forelse($users as $item)
        <div
            style="background: #c2c2c2ff; border-radius: 8px; padding: 15px; text-align: right; box-shadow: 0 0 5px rgba(0,0,0,0.05);">
            <a href="{{ route('admin.userdashboard', $item->id) }}" class="my-link">
                <strong>نام: {{ $item->fname }}</strong><br><br>


                <strong>مجموع هزینه پیام ها: {{ number_format(($sms_count[$item->id]?? 0 )*$cost) }} ریال</strong><br>
                <strong>تعداد پیام ها: {{ number_format($sms_count[$item->id]?? 0 )}} </strong>

            </a>
            <small style="color: gray;">{{ $item->created_at }}</small>
        </div>
        @empty
        <p style="color: gray;">هنوز پیامی ثبت نشده</p>
        @endforelse


    </div>

</div>

@endsection