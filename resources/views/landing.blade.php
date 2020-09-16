@extends('layouts.simple2')

@section('content')
    <nav class="navbar navbar-expand-md  fixed-top maine-menu">
    <div class="container">
      <button class="navbar-toggler ml-auto" data-target="#my-nav" onclick="myFunction(this)" data-toggle="collapse"> <span class="bar1"></span> <span class="bar2"></span> <span class="bar3"></span> </button>
      <div id="my-nav" class="collapse navbar-collapse">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item active"> <a class="nav-link roboto-font" href="#">Inicio</a> </li>
          <li class="nav-item"> <a class="nav-link" href="#about" tabindex="-1" aria-disabled="true">Nosotros</a></li>
          <li class="nav-item"> <a class="nav-link" href="#activity" tabindex="-1" aria-disabled="true">Servicios</a></li>
          <li class="nav-item"> <a class="nav-link" href="#portfolio" tabindex="-1" aria-disabled="true">Galería</a></li>
          <li class="nav-item"> <a class="nav-link" href="#testimonial" tabindex="-1" aria-disabled="true">Testimonios</a></li>
          <li class="nav-item"> <a class="nav-link" href="#contact" tabindex="-1" aria-disabled="true">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container-fluid fh5co-home-banner">
    <div class="card"> <img class="card-img" src="img/portada2.jpg" alt="">
      <div class="card-img-overlay">
        <div class="center-text">
          <h2 class="card-title">Pasando esta contingencia estamos listos para festejar a lo grande</h2>
          <a href="#contact" class="btn">
            <svg width="201" height="51" viewBox="0 0 201 51">
              <defs>
                <style>
                
              </style>
              <linearGradient id="linear-gradient" x1="140.508" y1="50.5" x2="60.492" y2="0.5" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#D0C304"/>
                <stop offset="1" stop-color="#fff"/>
              </linearGradient>
            </defs>
            <rect id="Rounded_Rectangle_1" data-name="Rounded Rectangle 1" class="cls-1" x="0.5" y="0.5" width="200" height="50" rx="25" ry="25"/>
          </svg>
        ¡COTIZAR!</a> </div>
      </div>
    </div>
  </div>
  <div class="container-fluid fh5co-two-img">
    <div class="row">
      <div class="col-sm-6 pr-0 pl-0">
        <div class="card"> <img class="card-img" src="img/girl1.jpg" alt="">
          <div class="card-img-overlay"> </div>
        </div>
      </div>
      <div class="col-sm-6 pr-0 pl-0">
        <div class="card"> <img class="card-img" src="img/girl2.jpg" alt="">
          <div class="card-img-overlay"> </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid fh5co-recent-work" style="background: url('https://cdn.hipwallpaper.com/i/71/2/YImypJ.jpg');">
    <div class="container contact-pop">
      <div class="row">
        <div class="col-md-6  pr-0">
          <div class="card"> <img class="card-img w-100" src="img/girl3.jpg" alt="">
            <div > </div>
          </div>
        </div>
        <div class="col-md-6 pl-0" id="about">
          <div class="content">
            <h3>Ivonne Arroyos</h3>
            <h4>Planeación de Eventos</h4>
            <hr />
            <p>Sed do eiusmod tempor incididunt ut labore et dolo magna aliqua. Ut enim ad minim veniam, quis nostd exercitation ullamco laboris nisi ut aliquip ex ea mo consequat. Duis aute irure dolor in reprehenderit in ullamco.</p>
            <a href="#" class="btn">CONTACT</a> </div>
          </div>
        </div>
      </div>
      <div class="container recent" id="activity">
        <div class="row">
          <h2>Nuestros Servicios</h2>
          <div class="owl-carousel owl-carousel2 owl-theme">
            <div>
              <div class="card"> <img class="card-img" src="img/recent-img1.jpg" alt="">
                <div class="card-img-overlay" style="background:rgba(0,0,0,.5): "> 
                  <div class="bottom-text">
                    <h5 class="card-title">Mobiliario</h5>
                    <p class="card-text">Sillas, Mesas, Aires y Calentones</p>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div class="card"> <img class="card-img" src="img/recent-img2.jpg" alt="">
                <div class="card-img-overlay"> 
                  <div class="bottom-text">
                    <h5 class="card-title">Pastelería</h5>
                    <p class="card-text">Pasteles, Postres, Cenas</p>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div class="card"> <img class="card-img" src="img/recent-img3.jpg" alt="">
                <div class="card-img-overlay"> 
                  <div class="bottom-text">
                    <h5 class="card-title">Floristeria</h5>
                    <p class="card-text">Decoración Para Tus Eventos</p>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div class="card"> <img class="card-img" src="img/recent-img4.jpg" alt="">
                <div class="card-img-overlay"> 
                  <div class="bottom-text">
                    <h5 class="card-title">Fotografía</h5>
                    <p class="card-text">Fotografía y Video Profesional</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  



  <!--INICIA GALERIA INSTAGRAM-->
  <style type="text/css">
   
  </style>
  <div class="container-fluid recent fh5co-portfolio" id="portfolio" style="background:none">
    <div class="container">
      <h2>Galería</h2>


      <div class="row">
       
        
        <div class="col-md-4 container-ig-item">
          <a href="gallery.html"><div class="sombra-ig-item">
            <p class="title-item-gallery">Decoración</p>
          </div></a>
          <img class="item-img" src="img/decoracion1.png" alt="">
        </div>

        <div class="col-md-4 container-ig-item">
          <div class="sombra-ig-item">
            <p class="title-item-gallery">Regalos</p>
          </div>
          <img class="item-img" src="img/regalos1.jpg" alt="">
        </div>

        <div class="col-md-4 container-ig-item">
          <div class="sombra-ig-item">
            <p class="title-item-gallery">Floristería</p>
          </div>
          <img class="item-img" src="img/floristeria1.jpg" alt="">
        </div>

        <div class="col-md-4 container-ig-item">
          <div class="sombra-ig-item">
            <p class="title-item-gallery">Catering</p>
          </div>
          <img class="item-img" src="img/catering1.jpg" alt="">
        </div>

        <div class="col-md-4 container-ig-item">
          <div class="sombra-ig-item">
            <p class="title-item-gallery">XV Años</p>
          </div>
          <img class="item-img" src="img/quinceanera1.jpg" alt="">
        </div>

        <div class="col-md-4 container-ig-item">
          <div class="sombra-ig-item">
            <p class="title-item-gallery">Mobiliario</p>
          </div>
          <img class="item-img" src="img/mobiliario1.jpg" alt="">
        </div>

       


      
        
      </div>
    </div>
  </div>
  <!--FIN GALERIA INSTAGRAM-->


  
  
  <div class="container-fluid fh5co-about-me" id="testimonial">
    <div id="my-carousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="card"> <img class="card-img d-block w-100" src="img/about-me-img.jpg" alt="">
          <div class="card-img-overlay" style="background-color: rgba(0, 0, 0, .57)">
            <h2>Testimonios</h2>
          </div>
        </div>
        <div class="carousel-item">
          <div class="carousel-caption d-md-block"> <img src="img/quote-icon.png" alt="">
            <p>Mega Decor...  Siempre feliz y satisfecha por la calidad, servicio y excelente gusto para que mis eventos queden al 100!!! Siempre me sacas de todos mis apuros aunque sea a ultimo momento, me encanta tu tención y dedicación... una vez más gracias, quedo todo super lindo y rico</p>
          </div>
        </div>
        <div class="carousel-item active">
          <div class="carousel-caption d-md-block"> <img src="img/quote-icon.png" alt="">
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo</p>
          </div>
        </div>
        <div class="carousel-item">
          <div class="carousel-caption d-md-block"> <img src="img/quote-icon.png" alt="">
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo</p>
          </div>
        </div>
      </div>
      <ol class="carousel-indicators">
        <li data-target="#my-carousel" data-slide-to="0" > <img src="img/about-me-img1.png" alt=""> <span>Ana Sandoval</span> </li>
        <li class="active" data-target="#my-carousel" data-slide-to="1" aria-current="location"> <img src="img/about-me-img2.png" alt=""> <span>Sherrie Rose</span> </li>
        <li data-target="#my-carousel" data-slide-to="2"> <img src="img/about-me-img3.png" alt=""> <span>Sherrie Rose</span> </li>
      </ol>
    </div>
  </div>
  <div class="container-fluid fh5co-insta-feed activity">
    <div class="container recent">
      <div class="row mb-5 pb-5">
        <div class="col-lg-6">
          <div class="twit-box">
            <div class="media mb-3"> <img class="align-self-start mr-3 rounded-circle" src="img/twit-girl-img.png" alt="">
              <div class="media-body">
                <h5 class="mb-0 mt-3">Mega Decor</h5>
                <p>@MegaMundoDecor</p>
              </div>
            </div>
            <p class="text-justify"> “Mega Mundo Decor te ofrece un servicio integral para eventos como: primera comunión, bautizos, quince años, fiestas temáticas para adultos, servicios empresariales, inauguraciones , decoración de agencias de autos, decoración de empresas y más.</p>
            <div class="clearfix"> <a href="#" class="btn btn-primary mt-2 float-right">Follow</a> </div>
          </div>
        </div>
        <div class="col-lg-6 feed-caro">
          <h2>Facebook</h2>
          <div class="owl-carousel owl-carousel4 owl-theme">
            <div>
              <div class="card"> <img class="card-img" src="img/feed-img1.png" alt="">
                <div class="card-img-overlay"> </div>
              </div>
            </div>
            <div>
              <div class="card"> <img class="card-img" src="img/feed-img2.png"  alt="">
                <div class="card-img-overlay"> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <h2 class="text-center d-block">Siguenos en nuestras redes</h2>
      <div class="row social-links">
        <ul class="nav mx-auto">
          <li class="nav-item"> <a class="nav-link" href="https://www.facebook.com/MegaMundoDecor/"><img src="img/facebook.png" alt=""></a> </li>

          <li class="nav-item"> <a class="nav-link" href="https://www.instagram.com/MegaMundoDecor/"><img src="img/facebook.png" alt=""></a> </li>
          
        </ul>
      </div>
    </div>
  </div>
  <footer class="container-fluid p-0 pr-0">
    <div class="row mr-0 ml-0">
      <div class="col-md-6 pr-0 pl-0 map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5908.257442219989!2d-106.1358223325694!3d28.670487629645212!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86ea42f567207a5b%3A0xc19a995b34cae0a6!2sAllium!5e0!3m2!1ses!2smx!4v1596519746422!5m2!1ses!2smx"  style="border:0" allowfullscreen></iframe>

      </div>
      <div class="col-md-6 content-us" style="background: url('https://cdn.hipwallpaper.com/i/71/2/YImypJ.jpg')">
        <div class="contact-form" id="contact">
          <h3 class="text-uppercase">Contacto</h3>
          <input type="text" class="form-control" placeholder="Nombre" style="border:solid; border-width: 1px; background: white">
          <input type="text" class="form-control" placeholder="Email" style="border:solid; border-width: 1px; background: white">
          <textarea class="form-control" placeholder="Mensaje" style="border:solid; border-width: 1px; background: white"></textarea>
          <button type="submit">Enviar</button>
        </div>
      </div>
    </div>
    <div class="copy pt-4 pb-4">
      <p><a href="https://freehtml5.co/" target="_blank"> &copy; 2020</a>  &nbsp;  |  &nbsp; <a href="https://freehtml5.co/" target="_blank">Megamundo Decor</a> &nbsp; | &nbsp;  All rights reserved</p>
    </div>
  </footer>
    <!-- END Hero -->
@endsection
