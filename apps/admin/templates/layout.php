<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php 
        	include_http_metas();
            include_metas();
            include_title();
            include_stylesheets();
            include_javascripts();
		?>
       	<link rel="shortcut icon" href="/images/favicon.ico" />
    </head>
	<?php 
		$ssBodyBG = ($sf_user->isAuthenticated()) ? '' : 'login-bg';
		$ssContainerId = ($sf_user->isAuthenticated()) ? 'id="container"' : '';
	?>
    <body id="<?php echo $ssBodyBG;?>">			
        <?php 
        	echo include_partial("global/header");// Top Level Navigation 
			echo '<div '.$ssContainerId.'>';
        		echo $sf_content;
			echo '</div>';
        	echo include_partial("global/footer");// Include Footer Section  
		?>
    </body>
</html>