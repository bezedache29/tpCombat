<?php
    include('config/init.php');

    include('header.php');
?>
<section class="attente">
    <h1 class="titre_combat">Combat en Cours</h1>
</section>
<script>
    const titre = document.querySelector('.titre_combat');
    titre.style.position = "absolute";

    let topPos = 0;
    let dir = 1;

    function hautBas() {
        if(topPos == 300) {
            dir = -1;
        }else if(topPos == 50) {
            dir = 1;
        }
        topPos += 2 * dir;
        titre.style.top = `${topPos}px`;
        requestAnimationFrame(hautBas);
    }

    requestAnimationFrame(hautBas);
</script>
<?php
    header("refresh:10;url=resultats_combat.php");
?>