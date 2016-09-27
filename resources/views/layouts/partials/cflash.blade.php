@if(session()->has('c_flash_message'))
    {{dd('has')}}
    <script type="text/javascript">
        var flash_placeholder = document.getElementById('cflash_placeholder');


        var alert = document.createElement("div");
        alert.classList.add("alert");
        alert.classList.add("fade");
        alert.classList.add("in");

        @if(session('c_flash_message.level')=='info')
        alert.classList.add("alert-info");
        @elseif(session('c_flash_message.level')=='success')
        alert.classList.add("alert-success");
        @elseif(session('c_flash_message.level')=='danger')
        alert.classList.add("alert-danger");
        @elseif(session('c_flash_message.level')=='warning')
        alert.classList.add("alert-warning");
                @endif

        var href="<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
        var message='<strong>{{session('c_flash_message.title')}}</strong> {{session('c_flash_message.message')}}'
        alert.innerHTML=href;
        alert.innerHTML+=message;
        flash_placeholder.appendChild(alert);
    </script>

@endif