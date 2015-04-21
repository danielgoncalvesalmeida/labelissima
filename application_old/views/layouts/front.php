<!DOCTYPE html>
<html lang="fr">
	<head>
	<?php if(!empty($meta['title'])): ?><title><?php echo $meta['title'] ?></title><?php endif; ?>
    
    <?php if(!empty($meta['description'])): ?><meta name="description" content="<?php echo $meta['description'] ?>"><?php endif; ?>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="<?php echo sbase_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="all">
    <!-- App specific -->
    <link href="<?php echo sbase_url() ?>assets/css/styles.css" rel="stylesheet" media="all">
    
    <!-- Controller output - CSS -->
    <?php echo output_css(); ?>
    <!-- /Controller output - CSS -->
    <script>
        var base_url = <?php echo '"'.  sbase_url().'"' ?>;
        var csrf_token_name = <?php echo '"'.$this->security->get_csrf_token_name().'"' ?>;
        var csrf_token_hash = <?php echo '"'.$this->security->get_csrf_hash().'"' ?>;
    </script>    

	</head>
<body <?php if(isset($page_name)): ?>id="<?php echo $page_name ?>"<?php endif; ?> >
    
<!-- container -->
<div class="container">

            
            <!--start: Navigation -->
            <div class="navbar navbar-inverse">
                <div class="navbar-inner">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Restaurant La Belissima</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active"><a href="index.html">Home</a></li>
                            <li><a href="about.html">About</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Features<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="social-icons.html">Social Icons</a></li>
                                    <li><a href="icons.html">Icons</a></li>
                                    <li><a href="typography.html">Typography</a></li>
                                    <li><a href="shortcodes.html">Shortcodes</a></li>
                                    <li><a href="list-styles.html">List Styles</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Portfolio<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="portfolio3.html">3 Columns</a></li>
                                    <li><a href="portfolio4.html">4 Columns</a></li>
                                </ul>
                            </li>                                   
                            <li><a href="services.html">Services</a></li>
                            <li><a href="pricing.html">Pricing</a></li>
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="contact.html">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>  
            <!--end: Navigation -->
                                              


<!-- Views -->
<?php echo $output ?>
<!-- /Views -->    

<div class="clearfix"><br /></div>

</div>
<!-- /container -->

    <script src="<?php echo sbase_url() ?>assets/jquery/jquery-1.11.0.min.js"></script>
    <script src="<?php echo sbase_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>    
    
    <!-- Controller output - JS -->
    <?php echo output_js(); ?>
    <!-- /Controller output - JS -->
    
    <script type="text/javascript">  
        //$('body').on('touchstart.dropdown','.dropdown-menu',function(e) {e.stopPropagation();});
        $(document).ready(function () {  
            $('.dropdown-toggle').dropdown();  
        });  
    </script> 
</body>
</html>