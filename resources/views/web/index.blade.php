<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>.:CANAZATEL:.</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="icon" href="{{ asset('template-web/assets/img/favicon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('template-web/assets/img/apple-touch-icon.png') }}">

  <!-- Google Fonts -->

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="{{ asset('template-web/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template-web/assets/vendor/ionicons/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template-web/assets/vendor/animate.css/animate.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template-web/assets/vendor/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template-web/assets/vendor/venobox/venobox.css') }}">

  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="{{ asset('template-web/assets/css/style.css') }}">

  
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header-transparent">
    <div class="container">

    <img src="{{url('template-web/assets/img/logo.jpg')}}" width="20%">
      <div id="logo" class="pull-left">
        {{-- <h1><a href="index.html" class="scrollto">CANAZATEL</a></h1> --}}
    
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="{{url('/')}}">INICIO</a></li>
          <li><a href="#about">ACERCA DE</a></li>
          <li><a href="#features">SERVICIOS</a></li>
          <li><a href="#pricing">PRECIOS</a></li>
          <li><a href="#contact">CONTACTENOS</a></li>
          <li><a href="{{url('/login')}}">INGRESAR</a></li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- End Header -->

  <!-- ======= Intro Section ======= -->
  <section id="intro">

    <div class="intro-text">
      <h2>Bienvenido a CANAZATEL</h2>
      <p>Ofrecemos servicios de telecomunicaciones en Bolivia</p>
      <button type="button" class="btn-get-started" style="color: black;" data-toggle="modal" data-target="#modalSolicita">SOLICITA EL SERVICIO</button>
    </div>

    <div class="product-screens">

      <div class="product-screen-1 wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="0.6s">
        <img src="{{url('template-web/assets/img/product-screen-1.png')}}" alt="">
      </div>

      <div class="product-screen-2 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.6s">
        <img src="{{url('template-web/assets/img/product-screen-2.png')}}" alt="">
      </div>

      <div class="product-screen-3 wow fadeInUp" data-wow-duration="0.6s">
        <img src="{{url('template-web/assets/img/product-screen-3.png')}}" alt="">
      </div>

    </div>

  </section><!-- End Intro Section -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="section-bg">
      <div class="container-fluid">
        <div class="section-header">
          <h3 class="section-title">Acerca de Nosotros</h3>
          <span class="section-divider"></span>
          <p class="section-description">
            Somos una empresa que ofrecemos servicios de TV Cable e Internet en Bolivia
          </p>
        </div>

        <div class="row">
          <div class="col-lg-6 about-img wow fadeInLeft">
            <img src="{{url('template-web/assets/img/about-img.jpg')}}" alt="">
          </div>

          <div class="col-lg-6 content wow fadeInRight">
            <h2>MISION</h2>
            <h3>Proporcionar servicio de telecomunicaciones a través de redes tecnológicamente actualizadas y modernas, cumpliendo la normativa vigente e impulsando el crecimiento económico productivo de nuestro país; logrando q todos los habitantes en los cuales tenemos nuestra red accedan a la comunicación, bajo premisas de calidad y tarifas equitativas acorde a la población.</h3>
            <h2>VISION</h2>
            <h3>Para la gestión 2024 nos comprometemos a sumar todos nuestros esfuerzos para lograr mantener CANAZATEL TELECOMUNICACIONES SRL como una empresa líder en el ramo de las telecomunicaciones en el interior de nuestro país, con el fin de satisfacer la demanda y las necesidades de los habitantes de nuestra población.</h3>
            {{-- <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </p>

            <ul>
              <li><i class="ion-android-checkmark-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
              <li><i class="ion-android-checkmark-circle"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
              <li><i class="ion-android-checkmark-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
            </ul>

            <p>
              Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum Libero justo laoreet sit amet cursus sit amet dictum sit. Commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec
            </p> --}}
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Featuress Section ======= -->
    <section id="features">
      <div class="container">

        <div class="row">

          <div class="col-lg-8 offset-lg-4">
            <div class="section-header wow fadeIn" data-wow-duration="1s">
              <h3 class="section-title">SERVICIOS</h3>
              <span class="section-divider"></span>
            </div>
          </div>

          <div class="col-lg-4 col-md-5 features-img">
            <img src="{{url('template-web/assets/img/product-features.png')}}" alt="" class="wow fadeInLeft">
          </div>

          <div class="col-lg-8 col-md-7 ">

            <div class="row">

              <div class="col-lg-6 col-md-6 box wow fadeInRight">
                <div class="icon"><i class="fa fa-tv"></i></div>
                <h4 class="title"><a href="">TV Cable</a></h4>
                <p class="description">Contamos con los mejores y mas variados canales de paga</p>
              </div>
              <div class="col-lg-6 col-md-6 box wow fadeInRight" data-wow-delay="0.1s">
                <div class="icon"><i class="fa fa-internet-explorer"></i></div>
                <h4 class="title"><a href="">Internet</a></h4>
                <p class="description">Ofrecemos un servicio de Intenet rapido y fiable</p>
              </div>
            </div>

          </div>

        </div>

      </div>

    </section><!-- End Featuress Section -->
    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="section-bg">
      <div class="container">
        <div class="section-header">
          <h3 class="section-title">PRECIOS</h3>
          <span class="section-divider"></span>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="box featured wow fadeInUp">
              <h3>TV CABLE</h3>
              <h4><sup>Bs</sup>150<span> mes</span></h4>
              <ul>
                <li><i class="ion-android-checkmark-circle"></i> Paquete de canales completo</li>
                <li><i class="ion-android-checkmark-circle"></i> Instalacion</li>
              </ul>
            </div>
          </div>

          <div class="col-lg-6 col-md-6">
            <div class="box wow fadeInRight">
              <h3>INTERNET</h3>
              <h4><sup>Bs</sup>100<span> mes</span></h4>
              <ul>
                <li><i class="ion-android-checkmark-circle"></i> Internet veloz</li>
                <li><i class="ion-android-checkmark-circle"></i> Internet fiable</li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </section><!-- End Pricing Section -->
    <!-- ======= Gallery Section ======= -->
    <section id="gallery">
      <div class="container-fluid">
        <div class="section-header">
          <h3 class="section-title">Galeria</h3>
          <span class="section-divider"></span>
         {{--  <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p> --}}
        </div>

        <div class="row no-gutters">

          <div class="col-lg-4 col-md-6">
            <div class="gallery-item wow fadeInUp">
              <a href="assets/img/gallery/gallery-1.jpg" data-gall="portfolioGallery" class="venobox">
                <img src="{{url('template-web/assets/img/gallery/gallery-1.jpg')}}" alt="">
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="gallery-item wow fadeInUp">
              <a href="assets/img/gallery/gallery-2.jpg" data-gall="portfolioGallery" class="venobox">
                <img src="{{url('template-web/assets/img/gallery/gallery-2.jpg')}}" alt="">
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="gallery-item wow fadeInUp">
              <a href="assets/img/gallery/gallery-3.jpg" data-gall="portfolioGallery" class="venobox">
                <img src="{{url('template-web/assets/img/gallery/gallery-3.jpg')}}" alt="">
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="gallery-item wow fadeInUp">
              <a href="assets/img/gallery/gallery-4.jpg" data-gall="portfolioGallery" class="venobox">
                <img src="{{url('template-web/assets/img/gallery/gallery-4.jpg')}}" alt="">
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="gallery-item wow fadeInUp">
              <a href="assets/img/gallery/gallery-5.jpg" data-gall="portfolioGallery" class="venobox">
                <img src="{{url('template-web/assets/img/gallery/gallery-5.jpg')}}" alt="">
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="gallery-item wow fadeInUp">
              <a href="assets/img/gallery/gallery-6.jpg" data-gall="portfolioGallery" class="venobox">
                <img src="{{url('template-web/assets/img/gallery/gallery-6.jpg')}}" alt="">
              </a>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Gallery Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact">
      <div class="container">
        <div class="row wow fadeInUp">

          <div class="col-lg-4 col-md-4">
            <div class="contact-about">
              <h3>CANAZATEL</h3>
              <p>Servicio de telecomunicaciones en Bolivia, TV Cable e Internet</p>
              <div class="social-links">
                <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
                <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
                <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="info">
              <div>
                <i class="ion-ios-location-outline"></i>
                <p>La Paz - Bolivia</p>
              </div>

              <div>
                <i class="ion-ios-email-outline"></i>
                <p>canazatel@gmail.com</p>
              </div>

              <div>
                <i class="ion-ios-telephone-outline"></i>
                <p>+591 79877878</p>
              </div>

            </div>
          </div>

          <div class="col-lg-5 col-md-8">
            <div class="form">
              
              <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modalReclamo"><i class="fa fa-exclamation-circle fa-2x"></i> <br>ENVIAR UN RECLAMO</button>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 text-lg-left text-center">
          <div class="copyright">
            &copy; Copyright <strong>CANAZATEL</strong>. Todos los derechos reservados
          </div>
          <div class="credits">
        </div>
      </div>
      <div class="col-lg-6">
        <nav class="footer-links text-lg-right text-center pt-2 pt-lg-0">
          <a href="#intro" class="scrollto">INICIO</a>
          <a href="#about" class="scrollto">ACERCA DE</a>
        </nav>
      </div>
    </div>
  </div>
</footer><!-- End  Footer -->

<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>


<!-- INICIO MODAL SOLICITA -->
<div class="modal fade" id="modalSolicita">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Solicitud</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form id="form_solicitud" data-parsley-validate>
        <div class="modal-body">
          <div class="row ">
            <div class="form-group col-md-6">
              <label for="nom_cli">NOMBRES:</label>
              <input type="text" class="form-control may letras lmp" id="nom_cli" name="nom_cli" placeholder="Ingrese su nombre" required>
            </div>  
            <div class="form-group col-md-6">
              <label for="ape_cli">APELLIDOS:</label>
              <input type="text" class="form-control may letras lmp" id="ape_cli" name="ape_cli" placeholder="Ingrese sus apellidos" required>
            </div>  
            <div class=" form-group col-md-6">
              <label for="ci_cli" class="form-label">NRO DE CI / NIT:</label>
              <input type="text" class="form-control may lmp" name="ci_cli" placeholder="Nro. Cedula o Nro. NIT" required >
            </div>  
            <div class="form-group col-md-6">
              <label for="cel_cli">CELULAR:</label>
              <input type="text" class="form-control lmp" id="cel_cli" name="cel_cli" placeholder="Ingrese su numero de celular" required>
            </div>    
            <div class="form-group col-md-6">
              <label for="tel_cli">TELEFONO:</label>
              <input type="text" class="form-control lmp" id="tel_cli" name="tel_cli" placeholder="Ingrese su telefono">
            </div>  
            <div class="form-group col-md-6">
              <label for="">SUCURSAL:</label>
              <select class="form-control" name="id_suc" required>
                <option selected="" disabled="">-ESCOJA UNA SUCURSAL-</option>
                @foreach ($sucursales as $sucursal)
                <option value="{{$sucursal->ID_SUC}}">{{$sucursal->NOM_SUC}}</option>
                @endforeach
              </select>
            </div>  
            <div class="form-group col-md-6">
              <label for="dir_cli">DIRECCIÓN:</label>
              <input type="text" class="form-control may lmp" id="dir_cli" name="dir_cli" placeholder="Ingrese su direccion" required>
              <input type="hidden" name="lat_cli" id="lat_cli" value="">
              <input type="hidden" name="lng_cli" id="lng_cli" value="">
            </div>  
            <div class="form-group col-md-6">
              <label for="">DESCRIPCION DE LA DIRECCIÓN:</label>
              <textarea class="form-control may lmp" name="des_dir" rows="3"></textarea>
            </div>  
            <div class="col-md-12 ">
              <div style="width: 100%; height: 300px;" id="map"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="submit" class="btn btn-primary" id="btn_registra"><i class="fa fa-check"></i> Registrar solicitud</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- FIN MODAL SOLICITA -->
<!-- INICIO MODAL RECLAMO -->
<div class="modal fade" id="modalReclamo">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Reclamo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form id="form_reclamo" data-parsley-validate>
        <div class="modal-body">
          <div class="row ">
            <div class="alert alert-warning text-center">
              Puede enviar un reclamo directamente a nuestros tecnicos, para ello debe ingresar su numero de cedula o NIT, asi para que podamos monitorear y solucionar su problema lo mas pronto posible
            </div> 
            <div class="form-group col-md-6">
              <label for="tel_cli">SU NUMERO DE CI O NIT:</label>
              <input type="text" class="form-control lmp" id="ci_cli" name="ci_cli" placeholder="Numero de Cedula o NIT">
            </div>  
            <div class="form-group col-md-6">
              <label for="">DESCRIPCION DEL PROBLEMA:</label>
              <textarea class="form-control may lmp" name="rec_rec" rows="3"></textarea>
            </div>  

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          <button type="button" class="btn btn-danger" onclick="reclamo()" id="btn_reclamo"><i class="fa fa-check"></i> Enviar reclamo</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- FIN MODAL RECLAMO -->

<!-- Vendor JS Files -->
<script src="{{ asset('template-web/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('template-web/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template-web/assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('template-web/assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('template-web/assets/vendor/wow/wow.min.js') }}"></script>
<script src="{{ asset('template-web/assets/vendor/venobox/venobox.min.js') }}"></script>
<script src="{{ asset('template-web/assets/vendor/superfish/superfish.min.js') }}"></script>
<script src="{{ asset('template-web/assets/vendor/hoverIntent/hoverIntent.js') }}"></script>
<script src="{{ asset('template/bower_components/validacion/mivalidacion.js') }}"></script>
<script src="{{ asset('template/bower_components/parsley/parsley.js') }}"></script>
<script src="{{ asset('template-web/assets/vendor/sweetalert2/sweetalert2.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('template-web/assets/js/main.js') }}"></script>
<script type="text/javascript">
  var map;
  var ubicacionDefecto = { lat: -16.495720314116124, lng: -68.133516089556 };
  //INICIO MI UBICACION
  function addYourLocationButton(map, marker) 
  {

    google.maps.event.addListener(map, 'dragend', function() {
      $('.tu_ubicacion').css('background-position', '0px 0px');
    });
    $(".tu_ubicacion").click(function (e) {

      var imgX = '0';
      var animationInterval = setInterval(function(){
        if(imgX == '-18') imgX = '0';
        else imgX = '-18';
        $('.tu_ubicacion').css('background-position', imgX+'px 0px');
      }, 500);
      if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
          marker.setPosition(latlng);
          map.setCenter(latlng);
          clearInterval(animationInterval);
          $('.tu_ubicacion').css('background-position', '-144px 0px');
        });
      }
      else{
        clearInterval(animationInterval);
        $('.tu_ubicacion').css('background-position', '0px 0px');
      }
    });
  }
  //FIN MI UBICACION

  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: ubicacionDefecto
    });
    var icon = {
        url: "{{url('img/pin.png')}}", // url
        scaledSize: new google.maps.Size(50, 70), // scaled size
        origin: new google.maps.Point(0,0), // origin
        anchor: new google.maps.Point(20, 50) // anchor
      };
      var marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        title: 'Mi ubicacion',
        position: ubicacionDefecto,

      });
      addYourLocationButton(map, marker);
      var geocoder = new google.maps.Geocoder();
      google.maps.event.addListener(marker, 'position_changed', function () {
        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();
        $('#lat_cli').val(lat);
        $('#lng_cli').val(lng);
        geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            console.log(results);
            var address = results[0]['formatted_address'];
            var lat = results[0].geometry.location.lat();
            var lng = results[0].geometry.location.lng();
            $('#dir_cli').val(address);
          }
        });
      });
      function toggleBounce() {
        if (marker.getAnimation() !== null) {
          marker.setAnimation(null);
        } else {
          marker.setAnimation(google.maps.Animation.BOUNCE);
        }
      }
    }
    $(document).ready(function(e) {
      initMap();
    }); 

  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADOvOZ1ysdf-hdsro_vxzKuT4fOR8i9pA&callback=initMap"></script>
</script>


<script type="text/javascript">
  $('#form_solicitud').on("submit",function(ev){
    ev.preventDefault();
    if ($(this).parsley().isValid()) {
      $.ajax({
        url: "{{route('solicitudWeb.store')}}",           
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        type: 'POST',   
        dataType:'JSON',         
        data: $('#form_solicitud').serialize(),
        beforeSend: function(){
          $('#btn_registra').html('<i class="fa fa-spinner fa-pulse"></i> Registrando...').prop('disabled',true);
        },
        success: function(data){
          console.log(data);
          Swal.fire('Exito', 'Su solicitud fue registrada exitosamente', 'success');
          $('#btn_registra').html('<i class="fa fa-check"></i>  Registrar solicitud').prop('disabled',false);
          limpia();
          $('#modalSolicita').modal('hide');
          
        },
        error: function(data, text, message){
          console.log(data);
          if (data.status && data.status==500) {  
            Swal.fire('Oops...', JSON.parse(data.responseText), 'error')
          }else{
            Swal.fire('Oops...', 'Algo salio mal, Refresque el navegador e intentelo nuevamente', 'error')
          }
          $('#btn_registra').html('<i class="fa fa-check"></i>  Registrar solicitud').prop('disabled',false);
        }
      });
    }
    return false;
  });

  function limpia(){
    $('.lmp').val('');
  }
</script>
<script type="text/javascript">
  function reclamo(){
    $.ajax({
        url: "{{route('reclamo.store')}}",           
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        type: 'POST',   
        dataType:'JSON',         
        data: $('#form_reclamo').serialize(),
        beforeSend: function(){
          $('#btn_reclamo').html('<i class="fa fa-spinner fa-pulse"></i> Registrando...').prop('disabled',true);
        },
        success: function(data){
          console.log(data);
          Swal.fire('Exito', 'Su reclamo fue enviado exitosamente', 'success');
          $('#btn_reclamo').html('<i class="fa fa-check"></i>  Registrar reclamo').prop('disabled',false);
          limpia();
          $('#modalReclamo').modal('hide');
          
        },
        error: function(data, text, message){
          console.log(data);
          if (data.status && data.status==500) {  
            Swal.fire('Oops...', JSON.parse(data.responseText), 'error')
          }else{
            Swal.fire('Oops...', 'Algo salio mal, Refresque el navegador e intentelo nuevamente', 'error')
          }
          $('#btn_reclamo').html('<i class="fa fa-check"></i>  Registrar reclamo').prop('disabled',false);
        }
      });
  }
</script>

</body>

</html>