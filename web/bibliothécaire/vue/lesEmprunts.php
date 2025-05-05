		<div class="flex-col shrink-0 section_3">
		<span class="self-center text_3">Emprunts en Cours</span>
		<div class="flex-container" style ="margin:50px 0">	   

		<?php 
		$i=0;
		foreach($tabAff as $ligne){
			$id=$tabid[$i];
			$i++;
			?>
       <div class="flex-item" style="display:inline-block;margin-bottom: 30px;">
            <span class="shrink-0 font_2"><?php echo "num: $ligne" ?></span>
            <div class="flex-col justify-start items-center shrink-0 text-wrapper fixed-width" style="display:inline-block; width:200px; text-align:center;float:right;">
            <span class=" font_3 text_5" style="display: flex; justify-content: center;"><a href='index.php?controleur=controleurEmpruntsEnCours&action=lireUnEmprunt&mail=<?php echo $id; ?>' style="text-decoration:none;color: #ffffff;">Voir l’emprunt</a></span>
			
			</div>
        </div>
    <?php } ?>