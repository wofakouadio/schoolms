<!--**********************************
	Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{asset('assets/vendor/global/global.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>

<!-- Apex Chart -->
{{--<script src="{{asset('assets/vendor/apexchart/apexchart.js')}}"></script>--}}
{{--<script src="{{asset('assets/vendor/chartjs/chart.bundle.min.js')}}"></script>--}}

<!-- Chart piety plugin files -->
{{--<script src="{{asset('assets/vendor/peity/jquery.peity.min.js')}}"></script>--}}

<!-- Dashboard 1 -->
<script src="{{asset('assets/js/dashboard/dashboard-1.js')}}"></script>

<script src="{{asset('assets/vendor/owl-carousel/owl.carousel.js')}}"></script>

<!-- Material color picker -->
{{--<script src="{{asset('assets/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>--}}
{{--<script src="{{asset('assets/vendor/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js')}}"></script>--}}

<!-- pickdate -->
{{--<script src="{{asset('assets/vendor/pickadate/picker.js')}}"></script>--}}
{{--<script src="{{asset('assets/vendor/pickadate/picker.time.js')}}"></script>--}}
{{--<script src="{{asset('assets/vendor/pickadate/picker.date.js')}}"></script>--}}

<!-- sweetalert -->
<script src="{{asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>

<!-- Datatable -->
<script src="{{asset('assets/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
{{--<script src="{{asset('assets/js/plugins-init/datatables.init.js')}}"></script>--}}

<script src="{{asset('assets/js/custom.min.js')}}"></script>
<script src="{{asset('assets/js/dlabnav-init.js')}}"></script>
<script src="{{asset('assets/js/styleSwitcher.js')}}"></script>

<!-- custom script to load preloader preset -->
<script>
function JobickCarousel()
	{

		/*  testimonial one function by = owl.carousel.js */
		jQuery('.front-view-slider').owlCarousel({
			loop:false,
			margin:30,
			nav:true,
			autoplaySpeed: 3000,
			navSpeed: 3000,
			autoWidth:true,
			paginationSpeed: 3000,
			slideSpeed: 3000,
			smartSpeed: 3000,
			autoplay: false,
			animateOut: 'fadeOut',
			dots:true,
			navText: ['', ''],
			responsive:{
				0:{
					items:1,

					margin:10
				},

				480:{
					items:1
				},

				767:{
					items:3
				},
				1750:{
					items:3
				}
			}
		})
	}

	jQuery(window).on('load',function(){
		setTimeout(function(){
			JobickCarousel();
		}, 1000);
	});
</script>

{{-- custom scripts --}}
@include('custom-functions/SchoolDataJS')
@stack('page-js')
@stack('datatable')

