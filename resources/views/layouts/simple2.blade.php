<!doctype html>
<html >
    <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://megadecor.adpro3d-os.com/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://megadecor.adpro3d-os.com/assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;1,100;1,300;1,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;1,100;1,300;1,400&display=swap" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

  <title>Mega Decor</title>
  <style type="text/css">
    html {
  scroll-behavior: smooth;
  font-family: 'Roboto', sans-serif;
}
.roboto-font{
    font-family: 'Roboto', sans-serif !important;  
}
.cls-1 {
                  fill: none;
                  stroke-width: 1px;
                  stroke: url(#linear-gradient);
                }
                .item-img{
      width: 100%;
    }
    .container-ig-item{
     overflow: hidden;
     height: 300px;
     width: 100%;
     margin-bottom: 20px;
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
      color: black;
      font-size: 20px;
      font-weight: bold;
      padding: 10px 30px;
      padding-bottom: 0;
      width: 100%;
      text-align: center;
      

    }
  </style>
    </head>
    <body class="roboto-font">
        <!-- Page Container -->
        <!--
            Available classes for #page-container:

        GENERIC

            'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

        SIDEBAR & SIDE OVERLAY

            'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
            'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
            'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
            'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
            'sidebar-inverse'                           Dark themed sidebar

            'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
            'side-overlay-o'                            Visible Side Overlay by default

            'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

            'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

        HEADER

            ''                                          Static Header if no class is added
            'page-header-fixed'                         Fixed Header

        HEADER STYLE

            ''                                          Classic Header style if no class is added
            'page-header-modern'                        Modern Header style
            'page-header-inverse'                       Dark themed Header (works only with classic Header style)
            'page-header-glass'                         Light themed Header with transparency by default
                                                        (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
            'page-header-glass page-header-inverse'     Dark themed Header with transparency by default
                                                        (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

        MAIN CONTENT LAYOUT

            ''                                          Full width Main Content if no class is added
            'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
            'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
        -->
        <div id="page-container" class="main-content-boxed">
            <!-- Main Container -->
            <main id="main-container">
                @yield('content')
            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

       

        <!-- Codebase Core JS -->
       
 <!-- jQuery first, then Popper.js, then Bootstrap JS --> 
 <script src="http://megadecor.adpro3d-os.com/assets/js/jquery-3.3.1.slim.min.js"></script> 
 <script src="http://megadecor.adpro3d-os.com/assets/js/popper.min.js" ></script> 
 <script src="http://megadecor.adpro3d-os.com/assets/js/bootstrap.min.js"></script> 
 <script src="http://megadecor.adpro3d-os.com/assets/js/owl.carousel.min.js"></script> 
 <script src="http://megadecor.adpro3d-os.com/assets/js/main.js"></script>

 <script>
   $(document).ready(function() {
 $('a[href^="#"]').click(function() {
   var destino = $(this.hash);
   if (destino.length == 0) {
     destino = $('a[name="' + this.hash.substr(1) + '"]');
   }
   if (destino.length == 0) {
     destino = $('html');
   }
   $('html, body').animate({ scrollTop: destino.offset().top }, 500);
   return false;
 });
});
 </script>
        @yield('js_after')
    </body>
</html>
