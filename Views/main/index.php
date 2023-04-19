<p>Page d'accueil du site</p>
<?php if (isset($_SESSION['admin'])) :?> 
    <p>bonjour Admin</p> 
<?php else :?>  
    <p>bonjour User</p> 
<?php endif;?>
