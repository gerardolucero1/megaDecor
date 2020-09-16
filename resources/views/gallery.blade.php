@extends('layouts.simple2')

@section('content')
<nav class="navbar navbar-expand-md  fixed-top maine-menu">
  <div class="container">
    <button class="navbar-toggler ml-auto" data-target="#my-nav" onclick="myFunction(this)" data-toggle="collapse"> <span class="bar1"></span> <span class="bar2"></span> <span class="bar3"></span> </button>
    <div id="my-nav" class="collapse navbar-collapse">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"> <a class="nav-link" href="index2.html" style="color:black">Inicio</a> </li>
        <li class="nav-item"> <a class="nav-link" href="index2.html#about" tabindex="-1" aria-disabled="true" style="color:black">Nosotros</a></li>
        <li class="nav-item"> <a class="nav-link" href="index2.html#activity" tabindex="-1" aria-disabled="true" style="color:black">Servicios</a></li>
        <li class="nav-item active"> <a class="nav-link" href="index2.html#portfolio" tabindex="-1" aria-disabled="true">Galería</a></li>
        <li class="nav-item"> <a class="nav-link" href="index2.html#testimonial" tabindex="-1" aria-disabled="true" style="color:black">Testimonios</a></li>
        <li class="nav-item"> <a class="nav-link" href="index2.html#contact" tabindex="-1" aria-disabled="true" style="color:black">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>




<!--INICIA GALERIA INSTAGRAM-->
<style type="text/css">
  .item-img{
    width: 100%;
  }
  .container-ig-item{
   overflow: hidden;
   width: 100%;
   margin-bottom: 20px;
   height: 300px
  }
  
  .sombra-ig-item{
    width: calc(100% - 30px);
    height: 100%;
    background:none;
    position: absolute;
    transition: all .5s;
  }
  .sombra-ig-item:hover{
    width: calc(100% - 30px);
    height: 100%;
    background:rgba(0,0,0,.3);
    position: absolute;
    transition: all .5s;
    cursor: pointer;
  }
  .title-item-gallery{
    color: white;
    font-size: 20px;
    font-weight: bold;
    padding: 10px 30px;
    width: 100%;
    text-align: center;
    background:rgba(0,0,0,.3);

  }
</style>
<div class="container-fluid recent fh5co-portfolio" id="portfolio" style="background:none">
  <div class="container">
  <h2>{{$gallery->name}}</h2>
    <p style="font-style: italic;">Visita Nuestra sala de exhibición y conoce todos nuestros modelos <a href="">Agenda una cita</a></p>


    <div class="row">
     @foreach ($imagenes as $imagen) 
      <div class="col-md-4 container-ig-item">
      <a href="{{$imagen->imagen}}" data-fancybox="gallery" data-caption="Mantelería">
        <div class="sombra-ig-item">
        </div>
      </a>
        <img class="item-img" src="{{$imagen->imagen}}" alt="">
      </div>
      @endforeach

      
     


    
      
    </div>
  </div>
</div>
<!--FIN GALERIA INSTAGRAM-->





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
