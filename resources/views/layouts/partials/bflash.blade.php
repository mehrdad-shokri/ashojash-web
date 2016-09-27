
@if(session()->has('b_flash_message'))
    <script type="text/javascript">
        var flash_placeholder = document.getElementById('flash_placeholder');


        var alert = document.createElement("div");
        alert.classList.add("alert");
        alert.classList.add("fade");
        alert.classList.add("in");

        @if(session('b_flash_message.level')=='info')
        alert.classList.add("alert-info");
        @elseif(session('b_flash_message.level')=='success')
        alert.classList.add("alert-success");
        @elseif(session('b_flash_message.level')=='danger')
        alert.classList.add("alert-danger");
        @elseif(session('b_flash_message.level')=='warning')
        alert.classList.add("alert-warning");
                @endif

        var href="<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
        var message='<strong>{{session('b_flash_message.title')}}</strong> {{session('b_flash_message.message')}}'
        alert.innerHTML=href;
        alert.innerHTML+=message;
        flash_placeholder.appendChild(alert);
    </script>

@endif