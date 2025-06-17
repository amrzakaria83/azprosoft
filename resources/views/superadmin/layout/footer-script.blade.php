<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
    <span class="svg-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
            <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
        </svg>
    </span>
    <!--end::Svg Icon-->
</div>
<!--end::Scrolltop-->

<!--begin::Javascript-->
<script>var hostUrl = "{{asset('dash/assets/')}}";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('dash/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('dash/assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
@yield('script')
<!--end::Vendors Javascript-->

<!--end::Javascript-->
<script>

$(document).ready(function() {
$(window).keydown(function(event){
if(event.keyCode == 13) {event.preventDefault();
return false;}});});

var defaultThemeMode = "light";
var themeMode;
if ( document.documentElement ) {
    if ( document.documentElement.hasAttribute("data-bs-theme-mode")) {
        themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
    } else {
        if ( localStorage.getItem("data-bs-theme") !== null ) {
            themeMode = localStorage.getItem("data-bs-theme");
        } else {
            themeMode = defaultThemeMode;
        }
    }
    if (themeMode === "system") {
        if ( window.matchMedia("(prefers-color-scheme: dark)").matches == "dark") {
            themeMode = "dark";
        } else {
            themeMode = "light";
        }
    }
    document.documentElement.setAttribute("data-bs-theme", themeMode);
}
</script>
<script>
        function focusInput () {
        setTimeout(function() {
            document.getElementById("emp_id_att").focus();
            document.getElementById("emp_id_att_out").focus();
        }, 500);}
    </script>

<script>
    $("#emp_id_att").on('blur ', function() {
    var emp_id_att = $(this).val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
    type: "GET",
    url: "{{ url('superadmin/getemp')}}",
    data: {"emp_id_att": emp_id_att},
    success: function (data) {
    console.log(data.data);
    $("#name_ar").html(data.data);
    }});});
</script>
<script>
        $("#emp_id_att_out").on('blur', function() {
        var emp_id_att_out = $(this).val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
        type: "GET",
        url: "{{ url('superadmin/getemp')}}",
        data: {"emp_id_att": emp_id_att_out},
        success: function (data) {
        console.log(data.data);
        $("#name_ar_out").html(data.data);
        }});});
</script>

<script>
$(document).ready(function() {
    // Convert the current time to the Laravel application's timezone
    var nowInLaravelTimezone = moment().format('HH:mm:ss');
    // Set the value of the input field to the converted time
    $('#time_stt_now').val(nowInLaravelTimezone);
});
</script>
<?php
$message = session()->get("message");
$status = session()->get("status");
?>
<script>
    toastr.options = {
        "positionClass": "toastr-top-left"
    };
</script>
@if( session()->has("message"))
    @if( $status == 'error')
        <script>
            toastr.error("", "{{$message}}");
        </script>
    @else
    <script>
        toastr.success("", "{{$message}}");
    </script>
    @endif
@endif
