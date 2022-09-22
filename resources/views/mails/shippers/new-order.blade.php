@extends('mails.master')
@section('content')
    <div style="padding: 40px 0 20px">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="border-collapse: collapse;">
            <tr>
                <td style="color: #32502E; font-family: Arial, sans-serif;">
                    <h1 style="font-size: 32px; margin: 0 0 15px; font-weight: 400;">Có đơn hàng mới trong khu vực của
                        bạn</h1>
                    <h2 style="font-size: 16px; font-weight: 400">Đơn hàng #{{ $order->id }}</h2>
                </td>
            </tr>
            <tr>
                <td style="color: #32502E; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                    <p style="margin: 0;">Xin
                        chào,</p>
                    <p>Có một đơn hàng mới trong khu vực của bạn. Bấm vào nút "Xem đơn hàng" dưới đây để xem chi tiết và
                        nhận mua hộ đơn hàng.</p>
                    <p>Bạn cần hỗ trợ? Liên hệ qua tổng đài <a href="#" style="color: #519e3d;
                                        text-decoration: none;">0123 456 XXX</a> hoặc gửi email cho chúng tôi tại địa
                        chỉ <a href="mailto:alert.dichohohanoi@gmail.com" style="color: #519e3d;
                                            text-decoration: none;">alert.dichohohanoi@gmail.com</a>.</p>

                    <a type="button" href="{{ route('orderDetail', $order->id) }}"
                       style="padding: 16px 24px; margin: 10px 10px 10px 0; background-color:
                                           #519e3d; color: white; font-size: 1rem; border: none; border-radius: 30px;
                                           text-decoration: none; display: inline-block;">Xem đơn hàng</a>
                </td>
            </tr>
            <tr>
                <td style="color: #32502E; font-family: Arial, sans-serif;">
                    <h2 style="font-size: 20px; font-weight: 400; margin-top: 50px;">Địa chỉ người
                        nhận</h2>
                </td>
            </tr>
            <tr>
                <td style="color: #32502E; font-family: Arial, sans-serif;">
                    <table>
                        <tr>
                            <td style="vertical-align: top;">
                                <p style="font-size: 14px; margin: 10px 0;">
                                    {{ $order->shipping_name }}
                                </p>
                                <p style="font-size: 14px; margin: 10px 0;">
                                    {{ $order->shipping_street }}
                                </p>
                                <p style="font-size: 14px; margin: 10px 0;">
                                    {{ $order->ward->name . ', ' . $order->district->name }}
                                </p>
                                <p style="font-size: 14px; margin: 10px 0;">
                                    {{ $order->shipping_phone }}
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="color: #32502E; font-family: Arial, sans-serif;">
                    <h2 style="font-size: 20px; font-weight: 400; margin-top: 50px;">Thông tin đơn
                        hàng</h2>
                    <table border="0" cellpadding="0" cellspacing="0"
                           style="border-collapse: collapse;" width="100%">
                        @foreach($order->details as $detail)
                            <tr>
                                <td>
                                    <img src="{{ $detail->product->thumbnail }}" width="70"
                                         height="70" style="object-fit: contain;" alt="">
                                </td>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0"
                                           style="border-collapse: collapse;" width="100%">
                                        <tr>
                                            <td style="padding: 20px 0">
                                                {{ $detail->product->name }}<br>
                                                {{ number_format($detail->unit_price) }}
                                                đ{{ $detail->quantity > 1 ? ' x'.$detail->quantity : '' }}
                                            </td>
                                            <td align="right">
                                                <b>{{ number_format($detail->subtotal()) }}đ</b>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                        <tr style="border-top: 1px solid #e5e5e5">
                            <td width="20%"></td>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0"
                                       style="border-collapse: collapse;" width="100%">
                                    <tr>
                                        <td style="padding: 20px 0 20px;">
                                            Phí vận chuyển
                                        </td>
                                        <td style="padding: 20px 0 20px;" align="right">
                                            <b>0đ</b>
                                        </td>
                                    </tr>
                                    <tr style="border-top: 1px solid #e5e5e5;">
                                        <td style="padding: 15px 0;">
                                            Thành tiền
                                        </td>
                                        <td style="padding: 15px 0; font-size: 24px;" align="right">
                                            <b>{{ number_format($order->total_price) }}đ</b>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
@endsection
