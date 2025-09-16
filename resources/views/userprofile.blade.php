@extends('layouts.layout')

@section('content')

<div style="display: flex; justify-content: center; flex-wrap: wrap; max-width: 1200px; margin: 20px auto; gap: 20px; padding: 10px; box-sizing: border-box;">
    <!-- کارت خوشامدگویی -->
    <div style="flex: 0 1 500px; background:#fff; border-radius:10px; padding:15px; box-shadow:0 0 10px rgba(0,0,0,0.1); ">
        <center>
            <h4>سلام، {{ $admin->fname }} 👋</h4>
            <h5>پروفایل کاربر: {{ $data->fname }} {{ $data->lname }}</h5>

            <br>
            <form style=" width: 75px;" action="{{ route('logout') }}" method="post" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
            <br><br>
        </center>
        <!-- فیلتر پیام ها -->
        <div style="background: #cbcbcbff; border-radius: 10px; padding: 20px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 15px;">فیلتر پیام ها</h3>
            <form action="{{ route('admin.userdashboard', $data->id) }}" method="get">
                @csrf
                <p>از تاریخ</p>
                <input type="datext" data-jdp name="startDate" placeholder="از تاریخ" data-jdp-only-date required>
                <p>تا تاریخ</p>
                <input type="datext" data-jdp name="endDate" placeholder="تا تاریخ" data-jdp-only-date required>
                <input type="hidden" name="id" value="{{ $data->id }}">
                <button type="submit">ارسال</button>
            </form>
        </div>
    </div>
</div>



<!-- بخش پیام‌ها -->
<div style="flex: 3 1 500px; background:#fff; border-radius: 10px; padding: 20px; box-shadow:0 0 10px rgba(0,0,0,0.1);">

    <div style="background: #fff; border-radius: 10px; padding: 20px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom: 15px;">هزینه هر پیام: {{ number_format($cost) }} ریال</h3>
        <h4>مجموع هزینه پیام ها: </h4>
        <p>
            {{ number_format($total) }} ریال
        </p>
        <p>تعداد پیام ها: {{ number_format($sum) }}</p>
    </div>


    <h3 style="margin-bottom: 15px;">پیام‌های ارسال شده</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">

        @forelse($smslist as $item)
        <div
            style="background: #c2c2c2ff; border-radius: 8px; padding: 15px; text-align: right; box-shadow: 0 0 5px rgba(0,0,0,0.05);">
            <strong>شماره: {{ $item->number }}</strong>
            <p style="margin: 10px 0;">متن پیام ارسالی: {{ $item->sms }}</p>
            <p>تعداد پیام: {{ $item->count }}</p>
            <small
                style="color: gray;">{{ \Morilog\Jalali\Jalalian::fromCarbon($item->created_at)->format('Y/m/d H:i:s') }}</small>
        </div>
        @empty
        <p style="color: gray;">هنوز پیامی ثبت نشده</p>
        @endforelse


    </div>

</div>

@endsection