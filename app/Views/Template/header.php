<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
	<meta name="Author" content="Spruko Technologies Private Limited">
	<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />

	<!-- Title -->
	<title> SISRI - <?= $title; ?></title>

	<!-- Favicon -->
	<link rel="icon" href="<?= base_url() ?>/assets/img/brand/Sisri.png" type="image/x-icon" />

	<!-- Icons css -->
	<link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet">
	<!-- Bootstrap css -->
	<link href="<?= base_url() ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Internal Data table css -->
	<link href="<?= base_url() ?>/assets/plugins/datatable/datatables.min.css" rel="stylesheet" />
	<link href="<?= base_url() ?>/assets/plugins/datatable/responsive.dataTables.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/plugins/datatable/responsive.bootstrap5.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/plugins/datatable/css/buttons.bootstrap5.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/plugins/select2/css/select2.min.css" rel="stylesheet">
	<!--  Right-sidemenu css -->
	<link href="<?= base_url() ?>/assets/plugins/sidebar/sidebar.css" rel="stylesheet">
	<!-- P-scroll bar css-->
	<link href="<?= base_url() ?>/assets/plugins/perfect-scrollbar/p-scrollbar.css" rel="stylesheet" />
	<!--- Select2 css --->
	<link href="<?= base_url() ?>/assets/plugins/select2/css/select2.min.css" rel="stylesheet">
	<!---Internal Owl Carousel css-->
	<link href="<?= base_url() ?>/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet">
	<!---Internal  Multislider css-->
	<link href="<?= base_url() ?>/assets/plugins/multislider/multislider.css" rel="stylesheet">
	<!-- Sidemenu css -->
	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/sidemenu.css">
	<!--- Dark-mode css --->
	<link href="<?= base_url() ?>/assets/css/style-dark.css" rel="stylesheet">
	<!---Skinmodes css-->
	<link href="<?= base_url() ?>/assets/css/skin-modes.css" rel="stylesheet" />
	<!--- Animations css-->
	<link href="<?= base_url() ?>/assets/css/animate.css" rel="stylesheet">
	<!--Internal  Date time picker-slider css -->
	<link href="<?= base_url() ?>/assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/plugins/pickerjs/picker.min.css" rel="stylesheet">
	<!-- Internal Spectrum-colorpicker css -->
	<link href="<?= base_url() ?>/assets/plugins/spectrum-colorpicker/spectrum.css" rel="stylesheet">
	<!--- Internal Select2 css-->
	<link href="<?= base_url() ?>/assets/plugins/select2/css/select2.min.css" rel="stylesheet">
	<!--Internal  Quill css -->
	<link href="<?= base_url() ?>/assets/plugins/quill/quill.snow.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/plugins/quill/quill.bubble.css" rel="stylesheet">

	<!--  Owl-carousel css-->
	<link href="<?= base_url() ?>/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />

	<!-- Maps css -->
	<link href="<?= base_url() ?>/assets/plugins/jqvmap/jqvmap.min.css" rel="stylesheet">

	<!-- style css -->
	<link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/css/style-dark.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/css/boxed.css" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/css/dark-boxed.css" rel="stylesheet">
	<!---Internal Fileupload css-->
	<link href="<?= base_url() ?>/assets/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css" />

	<!---Internal Fancy uploader css-->
	<link href="<?= base_url() ?>/assets/plugins/fancyuploder/fancy_fileupload.css" rel="stylesheet" />

	<!--Internal Sumoselect css-->
	<link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/sumoselect/sumoselect.css">

	<!--Internal  TelephoneInput css-->
	<link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/telephoneinput/telephoneinput.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

	<style>
		p.cs {
			color: #dfb006;
			font-weight: bold;
		}

		p.csDI {
			color: green;
			font-weight: bold;
		}

		td {
			padding: 5px;
		}
	</style>

</head>

<!-- <body class="main-body app sidebar-mini"> -->

<body class="main-body app sidebar-mini" oncontextmenu="return false">

	<div class="preloader">
		<div id="global-loader">
			<img src="<?= base_url() ?>/assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
	</div>