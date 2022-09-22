@extends('layouts.index', ['card_width' => '768px'])
@section('title', 'Contact us')

@section('content')
    <div class="container">
        <div class="row h-100">
            <div class="col-12 p-0">
                <div class="card mb-0">
                    <div class="p-4">
                        <p>For inquiries, kindly contact us through the following channels:</p>
                        <div class="card-text">
                            <div>Email: contact@estudiez.test</div>
                            <div>Phone: (+84) 90 123 456</div>
                            <div>Address: So 8 Ton That Thuyet, Cau Giay, Hanoi, Vietnam</div>
                        </div>
                    </div>
                    <div class="p-4" style="height: 400px">
                        <iframe class="iframe-map"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.1013994271134!2d105.77964371462268!3d21.028628385998434!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454b32ecb92db%3A0x3964e6238a3bd088!2zOCBUw7RuIFRo4bqldCBUaHV54bq_dCwgTeG7uSDEkMOsbmgsIEPhuqd1IEdp4bqleSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1660369080945!5m2!1svi!2s"
                                style="border:0;width: 100%;height: 100%;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
