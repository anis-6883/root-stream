<script src="{{ asset('public/backend/plugins/core/core.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/backend/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/dropify/dropify.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('public/backend/js/template.js') }}"></script>
<script src="{{ asset('public/backend/js/dashboard-light.js') }}"></script>
<script src="{{ asset('public/backend/plugins/sweetalert2/sweetalert2@11.js') }}"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    @if (Session::has('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
            })
        @endif
        
    @if (Session::has('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}',
        })
    @endif

    @if (Session::has('warning'))
        Toast.fire({
            icon: 'warning',
            title: '{{ session('warning') }}',
        })
    @endif

    @foreach ($errors->all() as $error)
        Toast.fire({
            icon: 'error',
            title: '{{ $error }}',
        })
    @endforeach
</script>
@yield('js-script')
<script src="{{ asset('public/backend/js/custom.js') }}"></script>