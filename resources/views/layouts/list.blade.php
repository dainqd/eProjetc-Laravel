@php /** @var LengthAwarePaginator|Collection $data */ use Illuminate\Pagination\LengthAwarePaginator;use Illuminate\Support\Collection;

@endphp

@extends('layouts.index')
@section('extraCss')
    <style>
        .page-item:last-child .page-btn {
            border-bottom-right-radius: var(--bs-pagination-border-radius);
            border-top-right-radius: var(--bs-pagination-border-radius);
        }

        .page-item:first-child .page-btn {
            border-bottom-left-radius: var(--bs-pagination-border-radius);
            border-top-left-radius: var(--bs-pagination-border-radius);
        }

        .page-item:not(.active) .page-btn:hover {
            color: #fff;
        }

        .page-btn:hover {
            background-color: var(--theme-600);
            border-color: var(--theme-600);
            color: var(--bs-pagination-hover-color);
            z-index: 2;
        }

        .page-item:not(:first-child) .page-btn {
            margin-left: -1px;
        }

        .active > .page-btn, .page-link.active {
            background-color: var(--theme-600);
            border-color: var(--theme-600);
            color: var(--bs-pagination-active-color);
            z-index: 3;
        }

        .page-btn {
            background-color: var(--bs-pagination-bg);
            border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color);
            color: var(--theme-600);
            display: block;
            /*font-size: var(--bs-pagination-font-size);*/
            padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
            position: relative;
            text-decoration: none;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition-property: color, background-color, border-color, box-shadow;
            transition-duration: 0.15s, 0.15s, 0.15s, 0.15s;
            transition-timing-function: ease-in-out, ease-in-out, ease-in-out, ease-in-out;
            transition-delay: 0s, 0s, 0s, 0s;
            font-size: .875rem;
        }

    </style>
@endsection
@section('content')
    @yield('above')
    <form @yield('form') {{ View::hasSection('form') ? '' : 'action=""' }}>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        @if(View::hasSection("filter") || isset($sort_options))
                            <div class="card-header">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-md-6">
                                        <div class="row d-flex justify-content-start">
                                            @yield('filter')
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-5">
                                        <div class="row d-flex justify-content-end">
                                            <div class="col-md-6">
                                                @isset($sort_options)
                                                    <x-select name="sort" option-all="Sắp xếp mặc định"
                                                              icon="bi-sort-alpha-down" is-filter="true"
                                                              :options="$sort_options"
                                                              class="trigger-change"></x-select>
                                                @endisset
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-lg">
                                    <thead class="thead-dark">
                                    @yield('thead')
                                    </thead>
                                    <tbody>
                                    @if($data && sizeof($data) > 0)
                                        @yield('tbody')
                                    @else
                                        <tr class="odd">
                                            <td colspan="8" class="dataTables_empty text-center">No data</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            @yield('button-custom')
                            @if($data instanceof LengthAwarePaginator)
                                <div class="row mt-4">
                                    <div class="col-md-6 d-flex justify-content-start">
                                        {{--                                        @if($data->count())--}}
                                        {{--                                            Showing from {{ $data->firstItem() }} to {{ $data->lastItem() }} of--}}
                                        {{--                                            tổng số {{ $data->total() }} kết quả--}}
                                        {{--                                        @endif--}}
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <select name="limit" class="form-control trigger-change">--}}
                                        {{--                                                <option--}}
                                        {{--                                                    value="{{ request()->has('limit') ? request()->limit : $data->perPage() }}"--}}
                                        {{--                                                    selected hidden>--}}
                                        {{--                                                    {{ request()->has('limit') ? request()->limit : $data->perPage() }}--}}
                                        {{--                                                    kết quả / trang--}}
                                        {{--                                                </option>--}}
                                        {{--                                                @foreach($limit_options ?? [25, 50, 100, 200] as $option)--}}
                                        {{--                                                    <option value="{{ $option }}">--}}
                                        {{--                                                        {{ $option }} kết quả / trang--}}
                                        {{--                                                    </option>--}}
                                        {{--                                                @endforeach--}}
                                        {{--                                            </select>--}}
                                        {{--                                        </div>--}}
                                        <div style="margin-left: 20px;">
                                            {{--                                            {{ $data->appends(request()->input())->links() }}--}}


                                            @if ($data->hasPages())
                                                <nav aria-label="Page navigation example">
                                                    <ul class="pagination justify-content-end">
                                                        @if ($data->onFirstPage())
                                                            <li class="page-item disabled">
                                                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                                                            </li>
                                                        @else
                                                            <li class="page-item"><a class="page-btn"
                                                                                     href="{{ $data->previousPageUrl() }}">Previous</a>
                                                            </li>
                                                        @endif
                                                        <?php
                                                        // config
                                                        $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
                                                        ?>
                                                        @for ($i = 1; $i <= $data->lastPage(); $i++)
                                                            <?php
                                                            $half_total_links = floor($link_limit / 2);
                                                            $from = $data->currentPage() - $half_total_links;
                                                            $to = $data->currentPage() + $half_total_links;
                                                            if ($data->currentPage() < $half_total_links) {
                                                                $to += $half_total_links - $data->currentPage();
                                                            }
                                                            if ($data->lastPage() - $data->currentPage() < $half_total_links) {
                                                                $from -= $half_total_links - ($data->lastPage() - $data->currentPage()) - 1;
                                                            }
                                                            ?>
                                                            @if ($from < $i && $i < $to)
                                                                <li class="page-item {{ ($data->currentPage() == $i) ? ' active' : '' }}">
                                                                    <a class="page-btn"
                                                                       href="{{ $data->url($i) }}">{{ $i }}</a>
                                                                </li>
                                                            @endif
                                                        @endfor
                                                        @if ($data->hasMorePages())
                                                            <li class="page-item">
                                                                <a class="page-btn" href="{{ $data->nextPageUrl() }}"
                                                                   rel="next">Next</a>
                                                            </li>
                                                        @else
                                                            <li class="page-item disabled">
                                                                <a class="page-link" href="#">Next</a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @yield('modal')
@endsection

@section('extraCss')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    @yield('extraCss')
@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $('.trigger-change').change(function () {
            $('form').submit();
        });
    </script>
    @yield('extraJs')
@endsection
