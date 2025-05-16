<?
$text = "Campeão da Fórmula 1 em 1997, o canadense Jacques Villeneuve disse, em entrevista à revista Autosport, que gostaria de voltar à categoria. O ex-piloto da Williams ficou animado com as mudanças previstas para a temporada de 2010. \"Eu estou pensando em voltar a correr. Eu moro no Canadá, mas quando você vê os carros de Fórmula 1 com pneus slick e sem reabastecimento no próximo ano, que era tudo pelo que eu lutava, então é momento de você pensar\", disse.";
$newtext = wordwrap($text, 20, "<br />");
echo "$newtext\n";
?>