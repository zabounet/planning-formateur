<?php $link = "Home" ;?>

<p>Page d'accueil du site</p>
<?php if (isset($_SESSION['admin'])) :?> 
    <p>bonjour Admin</p> 
<?php elseif(isset($_SESSION['formateur'])) :?>  
    <p>bonjour User</p> 
<?php endif;?>
