<div class="form-group position-relative has-icon-left">
    <div id="reportrange" class="form-control" style="cursor: pointer; width: 100%">
        <span></span>
    </div>
    <div class="form-control-icon">
        <i class="bi bi-calendar"></i>
    </div>
</div>
<input type="hidden" name="start_date">
<input type="hidden" name="end_date">

<script>
    window.addEventListener('DOMContentLoaded', function () {
        const DISPLAY_DATE_FORMAT = "DD/MM/YYYY";
        const DB_DATE_FORMAT = "YYYY-MM-DD";

        const selector = $('#reportrange');
        const rangeText = $('#reportrange span');
        const startDateInput = $('[name="start_date"]');
        const endDateInput = $('[name="end_date"]');

        const url_start = '{{ request()->has('start_date') ? urldecode(request()->start_date) : '' }}';
        let start = url_start.length ? moment(url_start, DB_DATE_FORMAT) : moment('01-01-2021', DISPLAY_DATE_FORMAT);
        var url_end = '{{ request()->has('end_date') ? urldecode(request()->end_date) : '' }}';
        let end = url_end.length ? moment(url_end, DB_DATE_FORMAT) : moment();

        function cb(start, end) {
            rangeText.html(start.format(DISPLAY_DATE_FORMAT) + ' - ' + end.format(DISPLAY_DATE_FORMAT));
            startDateInput.val(start.format(DB_DATE_FORMAT));
            endDateInput.val(end.format(DB_DATE_FORMAT));
        }

        selector.daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'All time': [moment('01-01-2021', DISPLAY_DATE_FORMAT), moment()],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        selector.on('apply.daterangepicker', function(ev, picker) {
            $('form').submit();
        });
    })
</script>
