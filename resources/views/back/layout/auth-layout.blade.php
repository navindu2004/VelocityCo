<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>@yield('pageTitle')</title>

		<!-- Site favicon -->
		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="/back/vendors/images/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="/back/vendors/images/favicon-32x32.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="/back/vendors/images/favicon-16x16.png"
		/>

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="/back/vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="/back/vendors/styles/icon-font.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />
		<link rel="stylesheet" href="/extra-assets/ijabo/ijaboCropTool.min.css">
		@livewireStyles
@stack('stylesheets')
	</head>
	<body class="login-page">
		<div class="login-header box-shadow">
			<div
				class="container-fluid d-flex justify-content-between align-items-center"
			>
				<div class="brand-logo">
					<a href="login.html">
						<img src="/back/vendors/images/velocityco.svg" alt="" />
					</a>
				</div>
				<div class="login-menu">
					<ul>
						@if ( !Route::is('admin.*') )

						@if (Route::is('seller.login') )
						<li><a href="{{ route('seller.register') }}">Register</a></li>
						@else
						<li><a href="{{ route('seller.login') }}">Login</a></li>
						@endif
						@endif
					</ul>
				</div>
			</div>
		</div>
		<div
			class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
		>
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 col-lg-7">
						<img src="/back/vendors/images/login-page-img.png" alt="" />
					</div>
					<div class="col-md-6 col-lg-5">
						@yield('content')
					</div>
				</div>
			</div>
		</div>
		
		<!-- js -->
		<script src="/back/vendors/scripts/core.js"></script>
		<script src="/back/vendors/scripts/script.min.js"></script>
		<script src="/back/vendors/scripts/process.js"></script>
		<script src="/back/vendors/scripts/layout-settings.js"></script>
		<script src="/extra-assets/ijabo/ijaboCropTool.min.js"></script>
		<script src="/extra-assets/ijabo/jquery-1.7.1.min.js"></script>
		<script>
			if(navigator.userAgent.indexOf("Firefox") != -1){
				history.pushState(null, null, document.URL);
				window.addEventListener('popstate', function () {
					history.pushState(null, null, document.URL);
				});
			}
		</script>
		<script>
			window.addEventListener('showToastr', function(event){
				toastr.remove();
				if(event.detail[0].type === 'info' ){ toastr.info(event.detail[0].message); }
				else if(event.detail[0].type === 'success' ){ toastr.success(event.detail[0].message); }
				else if(event.detail[0].type === 'warning' ){ toastr.warning(event.detail[0].message); }
				else if(event.detail[0].type === 'error' ){ toastr.error(event.detail[0].message); }
				else{ return false; }
			});

			// document.addEventListener('livewire:init', ()=>{
			// 	Livewire.on('showToastr',(event)=>{
			// 		toastr.remove();
			// 	if(event[0].type === 'info' ){ toastr.info(event[0].message); }
			// 	else if(event[0].type === 'success' ){ toastr.success(event[0].message); }
			// 	else if(event[0].type === 'warning' ){ toastr.warning(event[0].message); }
			// 	else if(event[0].type === 'error' ){ toastr.error(event[0].message); }
			// 	else{ return false; }
			// 	});
			// });
		</script>
		@livewireScripts
        @stack('scripts')
		
		
	<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>
