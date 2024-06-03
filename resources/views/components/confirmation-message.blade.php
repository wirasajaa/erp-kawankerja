<script>
    $(document).ready(function() {
        $(document).on("click", '#btn-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const message = $(this).attr('message');
            const icon = $(this).attr('icon');
            swal({
                    title: "Are you sure?",
                    text: message ?? 'want to continue this action',
                    icon: icon ?? "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        })

    })
</script>
