<script src="{{asset('assets/dist/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assets/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/dist/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/dist/js/masonry.pkgd.min.js')}}"></script>
<script src="{{asset('assets/dist/js/jquery.barfiller.js')}}"></script>
<script src="{{asset('assets/dist/js/jquery.slicknav.js')}}"></script>
<script src="{{asset('assets/dist/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/dist/js/main.js')}}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function(){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            @if(session('alert_success'))
            timeOut: 4000
            @else
            timeOut: 10000
            @endif
        };
        @if(session('alert_success'))
            toastr.success('{{ session('alert_success') }}', 'Success');
        @endif
        @if(session('alert_error'))
            toastr.error('{{ session('alert_error') }}', 'Error');
        @endif
    });
</script>
