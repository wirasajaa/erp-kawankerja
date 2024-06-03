@if (session('system_success'))
    <script>
        swal("Good job!", "{{ session('system_success') }}", "success");
    </script>
@endif

@error('system_error')
    <script>
        swal("Something Wrong!", "{{ $message }}", "error");
    </script>
@enderror
