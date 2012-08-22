<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?= config('basepath'); ?>/static/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">

      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="<?= config('basepath'); ?>/static/css/bootstrap-responsive.css" rel="stylesheet">
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?= config('basepath'); ?>/admin">Kottu Baas</a>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span9">
  	    <form class="form-horizontal" action="<?= config('basepath'); ?>/admin/login" method="POST">
	    <fieldset>
	    <legend>Login</legend>
        <?php if($this->fail): ?>
        <div class="alert alert-error">
        Your login information is invalid
        </div>
        <?php endif; ?>
        
        <noscript>
        <div class="alert alert-error">
        <strong>Javascript is disabled on your browser!</strong> 
        Please do not attempt to log in as your password could potentially be
        viewed by unauthorized persons.
        </div>
        </noscript>
		<div class="control-group">
			<input type="hidden" name="salt" id="salt" value="<?= sha1(rand(0, time())); ?>" >
			<label class="control-label" for="user">Username</label>
			<div class="controls">
			<input type="text" class="input-xlarge" id="user" name="user" >
			</div>
			<br>
			<label class="control-label" for="pwd">Password</label>
			<div class="controls">
			<input type="password" class="input-xlarge" id="pwd" name="pwd" onblur="encrypt()">
			</div>
			
			<div class="form-actions">
			<button class="btn btn-primary" type="submit">Login</button>
			<button class="btn" type="reset">Reset</button>
			</div>
		</div>
	</fieldset>
	</form>
    </div><!--/span-->
    </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Kottu 2012</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script src="<?= config('basepath'); ?>/static/js/bootstrap.min.js"></script>
    <script src="<?= config('basepath'); ?>/static/js/sha1.js"></script>
	<script type="text/javascript">    
    function encrypt() {
        $('#pwd').val(CryptoJS.SHA1(CryptoJS.SHA1($('#pwd').val()) + $('#salt').val()));
    }
    </script>
  </body>
</html> 

