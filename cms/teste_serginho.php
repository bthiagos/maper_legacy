<?
$text = "Campe�o da F�rmula 1 em 1997, o canadense Jacques Villeneuve disse, em entrevista � revista Autosport, que gostaria de voltar � categoria. O ex-piloto da Williams ficou animado com as mudan�as previstas para a temporada de 2010. \"Eu estou pensando em voltar a correr. Eu moro no Canad�, mas quando voc� v� os carros de F�rmula 1 com pneus slick e sem reabastecimento no pr�ximo ano, que era tudo pelo que eu lutava, ent�o � momento de voc� pensar\", disse.";
$newtext = wordwrap($text, 20, "<br />");
echo "$newtext\n";
?>